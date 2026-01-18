<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Course;
use App\Models\QuizAttempt;
use App\Models\Quiz;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        // Get all courses taught by this instructor
        $instructorCourses = Course::where('created_by', auth()->id())->pluck('id');

        // Get all students enrolled in instructor's courses with their enrollment data
        $students = User::where('role', 'student')
            ->whereHas('enrollments', function($query) use ($instructorCourses) {
                $query->whereIn('course_id', $instructorCourses);
            })
            ->with(['enrollments' => function($query) use ($instructorCourses) {
                $query->whereIn('course_id', $instructorCourses)
                    ->with('course:id,title');
            }])
            ->get()
            ->map(function($student) use ($instructorCourses) {
                // Get all quiz attempts for this student in instructor's courses
                $quizAttempts = QuizAttempt::whereHas('quiz.course', function($query) use ($instructorCourses) {
                    $query->whereIn('id', $instructorCourses);
                })
                ->where('user_id', $student->id)
                ->whereNotNull('completed_at')
                ->get();

                // Calculate cumulative average grade using BEST attempt for each quiz
                $averageGrade = null;
                if ($quizAttempts->isNotEmpty()) {
                    // Group by quiz_id and get the best (highest percentage) attempt for each quiz
                    $bestAttempts = $quizAttempts->groupBy('quiz_id')->map(function($attempts) {
                        return $attempts->sortByDesc('percentage')->first();
                    });
                    
                    // Average the best attempts
                    $averageGrade = round($bestAttempts->avg('percentage'), 2);
                }

                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'email' => $student->email,
                    'enrolled_courses' => $student->enrollments->map(function($enrollment) {
                        return [
                            'id' => $enrollment->course->id,
                            'title' => $enrollment->course->title,
                            'enrolled_at' => $enrollment->created_at ? $enrollment->created_at->format('M d, Y') : 'N/A'
                        ];
                    }),
                    'total_courses' => $student->enrollments->count(),
                    'total_quiz_attempts' => $quizAttempts->count(),
                    'cumulative_grade' => $averageGrade
                ];
            });

        // Calculate overall analytics
        $allGrades = $students->pluck('cumulative_grade')->filter();
        $analytics = [
            'total_students' => $students->count(),
            'average_grade' => $allGrades->isNotEmpty() ? round($allGrades->avg(), 2) : 0,
            'highest_grade' => $allGrades->isNotEmpty() ? round($allGrades->max(), 2) : 0,
            'lowest_grade' => $allGrades->isNotEmpty() ? round($allGrades->min(), 2) : 0
        ];

        return Inertia::render('Instructor/Students/Index', [
            'students' => $students,
            'analytics' => $analytics
        ]);
    }

    public function show($id)
    {
        // Get student
        $student = User::where('role', 'student')->findOrFail($id);

        // Get all courses taught by this instructor
        $instructorCourses = Course::where('created_by', auth()->id())
            ->with(['quizzes', 'enrollments' => function($query) use ($id) {
                $query->where('user_id', $id);
            }])
            ->get();

        // Get detailed quiz performance for each course
        $coursePerformance = $instructorCourses->filter(function($course) {
            return $course->enrollments->isNotEmpty();
        })->map(function($course) use ($id) {
            // Get all quizzes for this course
            $quizzes = $course->quizzes->map(function($quiz) use ($id) {
                // Get all attempts for this student
                $attempts = QuizAttempt::where('quiz_id', $quiz->id)
                    ->where('user_id', $id)
                    ->whereNotNull('completed_at')
                    ->orderBy('attempt_date', 'desc')
                    ->get();

                // Get best attempt
                $bestAttempt = $attempts->sortByDesc('percentage')->first();

                return [
                    'quiz_id' => $quiz->id,
                    'quiz_title' => $quiz->title,
                    'passing_score' => $quiz->passing_score,
                    'attempts_count' => $attempts->count(),
                    'best_score' => $bestAttempt ? round($bestAttempt->percentage, 2) : null,
                    'best_attempt_date' => $bestAttempt && $bestAttempt->completed_at ? $bestAttempt->completed_at->format('M d, Y g:i A') : null,
                    'passed' => $bestAttempt ? ($bestAttempt->percentage >= $quiz->passing_score) : false,
                    'all_attempts' => $attempts->map(function($attempt) use ($quiz) {
                        return [
                            'attempt_number' => $attempt->attempt_number,
                            'score' => $attempt->score,
                            'total_points' => $attempt->total_points,
                            'percentage' => round($attempt->percentage, 2),
                            'passed' => $attempt->percentage >= $quiz->passing_score,
                            'completed_at' => $attempt->completed_at ? $attempt->completed_at->format('M d, Y g:i A') : 'N/A',
                            'time_spent' => $attempt->time_spent_seconds ? round($attempt->time_spent_seconds / 60) . ' min' : 'N/A'
                        ];
                    })
                ];
            });

            // Calculate course average
            $courseQuizScores = $quizzes->pluck('best_score')->filter();
            $courseAverage = $courseQuizScores->isNotEmpty() ? round($courseQuizScores->avg(), 2) : null;

            return [
                'course_id' => $course->id,
                'course_title' => $course->title,
                'enrolled_at' => $course->enrollments->first() && $course->enrollments->first()->created_at ? $course->enrollments->first()->created_at->format('M d, Y') : 'N/A',
                'quizzes' => $quizzes,
                'course_average' => $courseAverage,
                'quizzes_completed' => $quizzes->filter(function($q) { return $q['best_score'] !== null; })->count(),
                'total_quizzes' => $quizzes->count()
            ];
        })->values();

        // Calculate overall student statistics
        $allQuizScores = $coursePerformance->flatMap(function($course) {
            return $course['quizzes']->pluck('best_score')->filter();
        });

        $studentStats = [
            'total_quizzes_taken' => $allQuizScores->count(),
            'overall_average' => $allQuizScores->isNotEmpty() ? round($allQuizScores->avg(), 2) : 0,
            'highest_score' => $allQuizScores->isNotEmpty() ? round($allQuizScores->max(), 2) : 0,
            'lowest_score' => $allQuizScores->isNotEmpty() ? round($allQuizScores->min(), 2) : 0,
            'quizzes_passed' => $coursePerformance->sum(function($course) {
                return $course['quizzes']->filter(function($q) { return $q['passed']; })->count();
            })
        ];

        return Inertia::render('Instructor/Students/Show', [
            'student' => [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email
            ],
            'coursePerformance' => $coursePerformance,
            'studentStats' => $studentStats
        ]);
    }

    private function calculateStandardDeviation($data)
    {
        $count = count($data);
        if ($count < 2) {
            return 0;
        }

        $mean = array_sum($data) / $count;
        $sumSquares = array_reduce($data, function($carry, $value) use ($mean) {
            return $carry + pow($value - $mean, 2);
        }, 0);

        return sqrt($sumSquares / ($count - 1));
    }
}

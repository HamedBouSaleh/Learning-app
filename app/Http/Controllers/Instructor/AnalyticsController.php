<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Get all courses taught by this instructor
        $instructorCourses = Course::where('created_by', auth()->id())
            ->with(['quizzes' => function($query) {
                $query->with('lesson:id,title');
            }])
            ->get();

        // Get analytics for each quiz
        $quizAnalytics = [];
        
        foreach ($instructorCourses as $course) {
            foreach ($course->quizzes as $quiz) {
                // Get all students who attempted this quiz
                $studentIds = QuizAttempt::where('quiz_id', $quiz->id)
                    ->whereNotNull('completed_at')
                    ->distinct()
                    ->pluck('user_id');

                if ($studentIds->isEmpty()) {
                    continue; // Skip quizzes with no attempts
                }

                // Get best attempt for each student
                $bestScores = [];
                foreach ($studentIds as $studentId) {
                    $bestAttempt = QuizAttempt::where('quiz_id', $quiz->id)
                        ->where('user_id', $studentId)
                        ->whereNotNull('completed_at')
                        ->orderBy('percentage', 'desc')
                        ->first();
                    
                    if ($bestAttempt) {
                        $bestScores[] = $bestAttempt->percentage;
                    }
                }

                if (empty($bestScores)) {
                    continue;
                }

                // Calculate average
                $average = round(array_sum($bestScores) / count($bestScores), 2);

                // Calculate standard deviation
                $standardDeviation = $this->calculateStandardDeviation($bestScores);

                $quizAnalytics[] = [
                    'quiz_id' => $quiz->id,
                    'quiz_title' => $quiz->title,
                    'course_title' => $course->title,
                    'course_id' => $course->id,
                    'lesson_title' => $quiz->lesson ? $quiz->lesson->title : 'N/A',
                    'passing_score' => $quiz->passing_score,
                    'total_students' => count($bestScores),
                    'average_score' => $average,
                    'standard_deviation' => $standardDeviation,
                    'highest_score' => round(max($bestScores), 2),
                    'lowest_score' => round(min($bestScores), 2),
                    'pass_rate' => round((count(array_filter($bestScores, function($score) use ($quiz) {
                        return $score >= $quiz->passing_score;
                    })) / count($bestScores)) * 100, 2)
                ];
            }
        }

        // Sort by course and quiz title
        usort($quizAnalytics, function($a, $b) {
            $courseCompare = strcmp($a['course_title'], $b['course_title']);
            if ($courseCompare !== 0) {
                return $courseCompare;
            }
            return strcmp($a['quiz_title'], $b['quiz_title']);
        });

        // Calculate overall statistics
        $overallStats = [
            'total_quizzes' => count($quizAnalytics),
            'total_courses' => $instructorCourses->count(),
            'overall_average' => count($quizAnalytics) > 0 ? round(array_sum(array_column($quizAnalytics, 'average_score')) / count($quizAnalytics), 2) : 0,
            'avg_pass_rate' => count($quizAnalytics) > 0 ? round(array_sum(array_column($quizAnalytics, 'pass_rate')) / count($quizAnalytics), 2) : 0
        ];

        return Inertia::render('Instructor/Analytics/Index', [
            'quizAnalytics' => $quizAnalytics,
            'overallStats' => $overallStats
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

        return round(sqrt($sumSquares / ($count - 1)), 2);
    }
}

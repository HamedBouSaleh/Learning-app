<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        // My Courses - only enrolled courses
        $courses = Enrollment::where('user_id', auth()->id())
            ->with(['course.instructor'])
            ->get()
            ->map(function($enrollment) {
                $course = $enrollment->course;
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'short_description' => $course->short_description,
                    'long_description' => $course->long_description,
                    'category' => $course->category,
                    'difficulty' => $course->difficulty,
                    'estimated_duration' => $course->estimated_duration,
                    'thumbnail_url' => $course->thumbnail_url,
                    'enrollment_count' => $course->enrollment_count,
                    'instructor_name' => $course->instructor->name,
                    'is_enrolled' => true,
                    'progress' => $enrollment->progress_percentage,
                    'enrolled_at' => $enrollment->enrolled_at
                ];
            });

        return Inertia::render('Student/Courses/MyCourses', [
            'courses' => $courses
        ]);
    }

    public function browse(Request $request)
    {
        $query = Course::query()
            ->with('instructor')
            ->withCount('enrollments')
            ->where('is_published', true); // Only show published courses

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('long_description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        // Difficulty filter
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->input('difficulty'));
        }

        // Sort
        switch ($request->input('sort', 'newest')) {
            case 'popular':
                $query->orderByDesc('enrollment_count');
                break;
            case 'title':
                $query->orderBy('title');
                break;
            default: // newest
                $query->latest();
        }

        $courses = $query->get()->map(function($course) {
            $enrollment = Enrollment::where('course_id', $course->id)
                ->where('user_id', auth()->id())
                ->first();

            return [
                'id' => $course->id,
                'title' => $course->title,
                'short_description' => $course->short_description,
                'long_description' => $course->long_description,
                'category' => $course->category,
                'difficulty' => $course->difficulty,
                'estimated_duration' => $course->estimated_duration,
                'thumbnail_url' => $course->thumbnail_url,
                'enrollment_count' => $course->enrollment_count,
                'instructor_name' => $course->instructor->name,
                'is_enrolled' => !!$enrollment,
                'progress' => $enrollment ? $enrollment->progress_percentage : 0
            ];
        });

        return Inertia::render('Student/Courses/Browse', [
            'courses' => $courses,
            'filters' => [
                'search' => $request->input('search', ''),
                'category' => $request->input('category', ''),
                'difficulty' => $request->input('difficulty', ''),
                'sort' => $request->input('sort', 'newest')
            ]
        ]);
    }

    public function show($id)
    {
        $course = Course::with(['lessons', 'instructor', 'quizzes'])->findOrFail($id);
        $enrollment = Enrollment::where('course_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        $progress = $enrollment ? $enrollment->progress_percentage : 0;
        \Log::info("CourseController.show - Course: {$id}, User: " . auth()->id() . ", Progress: {$progress}");

        return Inertia::render('Student/Courses/Show', [
            'course' => [
                'id' => $course->id,
                'title' => $course->title,
                'short_description' => $course->short_description,
                'long_description' => $course->long_description,
                'category' => $course->category,
                'difficulty' => $course->difficulty,
                'estimated_duration' => $course->estimated_duration,
                'thumbnail_url' => $course->thumbnail_url,
                'enrollment_count' => $course->enrollment_count,
                'instructor_name' => $course->instructor->name,
                'instructor_email' => $course->instructor->email,
                'instructor_bio' => $course->instructor_bio,
                'is_enrolled' => !!$enrollment,
                'progress' => $progress
            ],
            'lessons' => $course->lessons->map(function($lesson) use ($enrollment) {
                $isCompleted = false;
                if ($enrollment) {
                    $isCompleted = \App\Models\LessonCompletion::where('lesson_id', $lesson->id)
                        ->where('user_id', auth()->id())
                        ->exists();
                }

                return [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'content' => $lesson->content,
                    'lesson_type' => $lesson->lesson_type,
                    'estimated_duration' => $lesson->estimated_duration,
                    'is_completed' => $isCompleted
                ];
            }),
            'quizzes' => $course->quizzes->map(function($quiz) {
                return [
                    'id' => $quiz->id,
                    'title' => $quiz->title,
                    'description' => $quiz->description,
                    'passing_score' => $quiz->passing_score,
                    'time_limit' => $quiz->time_limit
                ];
            })
        ]);
    }

    public function enroll($id)
    {
        $course = Course::findOrFail($id);
        
        $existing = Enrollment::where('course_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            return back()->with('info', 'You are already enrolled in this course.');
        }

        Enrollment::create([
            'course_id' => $id,
            'user_id' => auth()->id(),
            'enrolled_at' => now()
        ]);

        return redirect()->route('student.courses.show', $id)
            ->with('success', 'Successfully enrolled in the course!');
    }
}

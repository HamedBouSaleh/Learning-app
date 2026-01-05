<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\LessonCompletion;
use App\Models\Enrollment;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LessonController extends Controller
{
    public function show($id)
    {
        $lesson = Lesson::with(['course.instructor', 'course.lessons'])->findOrFail($id);
        
        // Check if user is enrolled
        $enrollment = Enrollment::where('course_id', $lesson->course_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$enrollment) {
            return redirect()->route('student.courses.show', $lesson->course_id)
                ->with('error', 'You must enroll in this course first.');
        }

        // Check if lesson is completed
        $isCompleted = LessonCompletion::where('lesson_id', $id)
            ->where('user_id', auth()->id())
            ->exists();

        // Get all lessons for sidebar
        $allLessons = $lesson->course->lessons->map(function($l) {
            $completed = LessonCompletion::where('lesson_id', $l->id)
                ->where('user_id', auth()->id())
                ->exists();

            return [
                'id' => $l->id,
                'title' => $l->title,
                'estimated_duration' => $l->estimated_duration,
                'is_completed' => $completed
            ];
        });

        // Get previous and next lessons
        $currentIndex = $lesson->course->lessons->search(function($l) use ($id) {
            return $l->id == $id;
        });

        $previousLesson = null;
        $nextLesson = null;

        if ($currentIndex > 0) {
            $prev = $lesson->course->lessons[$currentIndex - 1];
            $previousLesson = [
                'id' => $prev->id,
                'title' => $prev->title
            ];
        }

        if ($currentIndex < $lesson->course->lessons->count() - 1) {
            $next = $lesson->course->lessons[$currentIndex + 1];
            $nextLesson = [
                'id' => $next->id,
                'title' => $next->title
            ];
        }

        // Get attachments
        $attachments = Attachment::where('lesson_id', $id)->get()->map(function($attachment) {
            return [
                'id' => $attachment->id,
                'file_name' => $attachment->file_name,
                'file_url' => $attachment->file_url,
                'file_type' => $attachment->file_type
            ];
        });

        return Inertia::render('Student/Lessons/Show', [
            'lesson' => [
                'id' => $lesson->id,
                'title' => $lesson->title,
                'content' => $lesson->content,
                'video_url' => $lesson->video_url,
                'lesson_type' => $lesson->lesson_type,
                'estimated_duration' => $lesson->estimated_duration,
                'is_completed' => $isCompleted
            ],
            'course' => [
                'id' => $lesson->course->id,
                'title' => $lesson->course->title,
                'instructor_name' => $lesson->course->instructor->name
            ],
            'attachments' => $attachments,
            'allLessons' => $allLessons,
            'previousLesson' => $previousLesson,
            'nextLesson' => $nextLesson
        ]);
    }

    public function complete($id)
    {
        $lesson = Lesson::findOrFail($id);
        $userId = auth()->id();

        // Check enrollment
        $enrollment = Enrollment::where('course_id', $lesson->course_id)
            ->where('user_id', $userId)
            ->first();

        if (!$enrollment) {
            return response()->json(['error' => 'Not enrolled'], 403);
        }

        // Mark as complete
        $existing = LessonCompletion::where('lesson_id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$existing) {
            LessonCompletion::create([
                'lesson_id' => $id,
                'user_id' => $userId,
                'completed_at' => now()
            ]);

            // Update enrollment progress
            $this->updateCourseProgress($lesson->course_id, $userId);
        }

        return response()->json(['success' => true, 'message' => 'Lesson marked as complete']);
    }

    private function updateCourseProgress($courseId, $userId)
    {
        \Log::info("Updating course progress for user {$userId} in course {$courseId}");
        
        $enrollment = Enrollment::where('course_id', $courseId)
            ->where('user_id', $userId)
            ->first();

        if (!$enrollment) {
            \Log::warning("No enrollment found for user {$userId} in course {$courseId}");
            return;
        }

        $totalLessons = Lesson::where('course_id', $courseId)->count();
        \Log::info("Total lessons in course: {$totalLessons}");
        
        $completedLessons = LessonCompletion::whereIn('lesson_id', function($query) use ($courseId) {
            $query->select('id')
                ->from('lessons')
                ->where('course_id', $courseId);
        })->where('user_id', $userId)->count();
        
        \Log::info("Completed lessons for user {$userId}: {$completedLessons}");

        $progressPercentage = $totalLessons > 0 
            ? round(($completedLessons / $totalLessons) * 100) 
            : 0;

        \Log::info("Calculated progress percentage: {$progressPercentage}%");

        $enrollment->update([
            'progress_percentage' => $progressPercentage
        ]);
        
        \Log::info("Updated enrollment progress to {$progressPercentage}%");
    }
}

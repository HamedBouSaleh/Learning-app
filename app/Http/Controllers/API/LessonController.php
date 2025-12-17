<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LessonController extends Controller
{
    /**
     * Display a listing of lessons.
     */
    public function index()
    {
        $lessons = Lesson::with(['course', 'attachments'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $lessons
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created lesson.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|string|max:255',
            'lesson_type' => 'required|in:Video,Article,Mixed',
            'order_position' => 'required|integer',
            'estimated_duration' => 'nullable|integer'
        ]);

        $lesson = Lesson::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lesson created successfully',
            'data' => $lesson
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified lesson.
     */
    public function show($id)
    {
        $lesson = Lesson::with(['course', 'attachments', 'quizzes'])->find($id);

        if (!$lesson) {
            return response()->json([
                'success' => false,
                'message' => 'Lesson not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $lesson
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified lesson.
     */
    public function update(Request $request, $id)
    {
        $lesson = Lesson::find($id);

        if (!$lesson) {
            return response()->json([
                'success' => false,
                'message' => 'Lesson not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|string|max:255',
            'lesson_type' => 'sometimes|required|in:Video,Article,Mixed',
            'order_position' => 'sometimes|required|integer',
            'estimated_duration' => 'nullable|integer'
        ]);

        $lesson->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lesson updated successfully',
            'data' => $lesson
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified lesson.
     */
    public function destroy($id)
    {
        $lesson = Lesson::find($id);

        if (!$lesson) {
            return response()->json([
                'success' => false,
                'message' => 'Lesson not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $lesson->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lesson deleted successfully'
        ], Response::HTTP_OK);
    }
}

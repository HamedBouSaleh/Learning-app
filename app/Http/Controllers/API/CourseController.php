<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     * GET /api/courses
     */
    public function index()
    {
        $courses = Course::with(['creator', 'lessons'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $courses
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created course.
     * POST /api/courses
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'long_description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'difficulty' => 'required|in:Beginner,Intermediate,Advanced',
            'thumbnail_url' => 'nullable|string|max:255',
            'estimated_duration' => 'nullable|integer',
            'created_by' => 'required|exists:users,id',
            'is_published' => 'boolean'
        ]);

        $course = Course::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Course created successfully',
            'data' => $course
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified course.
     * GET /api/courses/{id}
     */
    public function show($id)
    {
        $course = Course::with(['creator', 'lessons', 'quizzes', 'enrollments'])->find($id);

        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $course
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified course.
     * PUT/PATCH /api/courses/{id}
     */
    public function update(Request $request, $id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'long_description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'difficulty' => 'sometimes|required|in:Beginner,Intermediate,Advanced',
            'thumbnail_url' => 'nullable|string|max:255',
            'estimated_duration' => 'nullable|integer',
            'is_published' => 'boolean'
        ]);

        $course->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully',
            'data' => $course
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified course.
     * DELETE /api/courses/{id}
     */
    public function destroy($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $course->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully'
        ], Response::HTTP_OK);
    }
}

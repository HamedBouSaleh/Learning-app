<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['user', 'course'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $enrollments
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'status' => 'required|in:Active,Completed,Dropped'
        ]);

        // Check if already enrolled
        $existing = Enrollment::where('user_id', $validated['user_id'])
            ->where('course_id', $validated['course_id'])
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'User already enrolled in this course'
            ], Response::HTTP_CONFLICT);
        }

        $enrollment = Enrollment::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Enrollment created successfully',
            'data' => $enrollment
        ], Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $enrollment = Enrollment::with(['user', 'course'])->find($id);

        if (!$enrollment) {
            return response()->json([
                'success' => false,
                'message' => 'Enrollment not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $enrollment
        ], Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $enrollment = Enrollment::find($id);

        if (!$enrollment) {
            return response()->json([
                'success' => false,
                'message' => 'Enrollment not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'status' => 'sometimes|required|in:Active,Completed,Dropped',
            'last_accessed_at' => 'nullable|date'
        ]);

        $enrollment->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Enrollment updated successfully',
            'data' => $enrollment
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $enrollment = Enrollment::find($id);

        if (!$enrollment) {
            return response()->json([
                'success' => false,
                'message' => 'Enrollment not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $enrollment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Enrollment deleted successfully'
        ], Response::HTTP_OK);
    }
}

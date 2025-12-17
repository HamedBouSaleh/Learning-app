<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with(['course', 'lesson', 'questions'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $quizzes
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'lesson_id' => 'nullable|exists:lessons,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'passing_score' => 'required|integer|min:0|max:100',
            'time_limit' => 'nullable|integer',
            'shuffle_questions' => 'boolean',
            'show_correct_answers' => 'boolean',
            'allow_retake' => 'boolean',
            'max_attempts' => 'nullable|integer'
        ]);

        $quiz = Quiz::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Quiz created successfully',
            'data' => $quiz
        ], Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $quiz = Quiz::with(['course', 'lesson', 'questions.answers'])->find($id);

        if (!$quiz) {
            return response()->json([
                'success' => false,
                'message' => 'Quiz not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $quiz
        ], Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::find($id);

        if (!$quiz) {
            return response()->json([
                'success' => false,
                'message' => 'Quiz not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'passing_score' => 'sometimes|required|integer|min:0|max:100',
            'time_limit' => 'nullable|integer',
            'shuffle_questions' => 'boolean',
            'show_correct_answers' => 'boolean',
            'allow_retake' => 'boolean',
            'max_attempts' => 'nullable|integer'
        ]);

        $quiz->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Quiz updated successfully',
            'data' => $quiz
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $quiz = Quiz::find($id);

        if (!$quiz) {
            return response()->json([
                'success' => false,
                'message' => 'Quiz not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $quiz->delete();

        return response()->json([
            'success' => true,
            'message' => 'Quiz deleted successfully'
        ], Response::HTTP_OK);
    }
}

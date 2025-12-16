<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all();
        return response()->json($quizzes, 200);
    }

    public function store(Request $request)
    {
        $quiz = Quiz::create($request->all());
        return response()->json($quiz, 201);
    }

    public function show(string $id)
    {
        $quiz = Quiz::findOrFail($id);
        return response()->json($quiz, 200);
    }

    public function update(Request $request, string $id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->update($request->all());
        return response()->json($quiz, 200);
    }

    public function destroy(string $id)
    {
        Quiz::destroy($id);
        return response()->json(null, 204);
    }
}
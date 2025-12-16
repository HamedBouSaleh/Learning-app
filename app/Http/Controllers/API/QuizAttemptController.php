<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuizAttempt;

class QuizAttemptController extends Controller
{
    public function index()
    {
        $quizAttempts = QuizAttempt::all();
        return response()->json($quizAttempts, 200);
    }

    public function store(Request $request)
    {
        $quizAttempt = QuizAttempt::create($request->all());
        return response()->json($quizAttempt, 201);
    }

    public function show(string $id)
    {
        $quizAttempt = QuizAttempt::findOrFail($id);
        return response()->json($quizAttempt, 200);
    }

    public function update(Request $request, string $id)
    {
        $quizAttempt = QuizAttempt::findOrFail($id);
        $quizAttempt->update($request->all());
        return response()->json($quizAttempt, 200);
    }

    public function destroy(string $id)
    {
        QuizAttempt::destroy($id);
        return response()->json(null, 204);
    }
}
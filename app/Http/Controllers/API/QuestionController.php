<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return response()->json($questions, 200);
    }

    public function store(Request $request)
    {
        $question = Question::create($request->all());
        return response()->json($question, 201);
    }

    public function show(string $id)
    {
        $question = Question::findOrFail($id);
        return response()->json($question, 200);
    }

    public function update(Request $request, string $id)
    {
        $question = Question::findOrFail($id);
        $question->update($request->all());
        return response()->json($question, 200);
    }

    public function destroy(string $id)
    {
        Question::destroy($id);
        return response()->json(null, 204);
    }
}
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Answer;

class AnswerController extends Controller
{
    public function index()
    {
        $answers = Answer::all();
        return response()->json($answers, 200);
    }

    public function store(Request $request)
    {
        $answer = Answer::create($request->all());
        return response()->json($answer, 201);
    }

    public function show(string $id)
    {
        $answer = Answer::findOrFail($id);
        return response()->json($answer, 200);
    }

    public function update(Request $request, string $id)
    {
        $answer = Answer::findOrFail($id);
        $answer->update($request->all());
        return response()->json($answer, 200);
    }

    public function destroy(string $id)
    {
        Answer::destroy($id);
        return response()->json(null, 204);
    }
}
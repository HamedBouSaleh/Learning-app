<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentAnswer;

class StudentAnswerController extends Controller
{
    public function index()
    {
        $studentAnswers = StudentAnswer::all();
        return response()->json($studentAnswers, 200);
    }

    public function store(Request $request)
    {
        $studentAnswer = StudentAnswer::create($request->all());
        return response()->json($studentAnswer, 201);
    }

    public function show(string $id)
    {
        $studentAnswer = StudentAnswer::findOrFail($id);
        return response()->json($studentAnswer, 200);
    }

    public function update(Request $request, string $id)
    {
        $studentAnswer = StudentAnswer::findOrFail($id);
        $studentAnswer->update($request->all());
        return response()->json($studentAnswer, 200);
    }

    public function destroy(string $id)
    {
        StudentAnswer::destroy($id);
        return response()->json(null, 204);
    }
}
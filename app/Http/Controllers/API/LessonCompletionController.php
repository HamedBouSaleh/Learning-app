<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LessonCompletion;

class LessonCompletionController extends Controller
{
    public function index()
    {
        $lessonCompletions = LessonCompletion::all();
        return response()->json($lessonCompletions, 200);
    }

    public function store(Request $request)
    {
        $lessonCompletion = LessonCompletion::create($request->all());
        return response()->json($lessonCompletion, 201);
    }

    public function show(string $id)
    {
        $lessonCompletion = LessonCompletion::findOrFail($id);
        return response()->json($lessonCompletion, 200);
    }

    public function update(Request $request, string $id)
    {
        $lessonCompletion = LessonCompletion::findOrFail($id);
        $lessonCompletion->update($request->all());
        return response()->json($lessonCompletion, 200);
    }

    public function destroy(string $id)
    {
        LessonCompletion::destroy($id);
        return response()->json(null, 204);
    }
}
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::all();
        return response()->json($lessons, 200);
    }

    public function store(Request $request)
    {
        $lesson = Lesson::create($request->all());
        return response()->json($lesson, 201);
    }

    public function show(string $id)
    {
        $lesson = Lesson::findOrFail($id);
        return response()->json($lesson, 200);
    }

    public function update(Request $request, string $id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->update($request->all());
        return response()->json($lesson, 200);
    }

    public function destroy(string $id)
    {
        Lesson::destroy($id);
        return response()->json(null, 204);
    }
}
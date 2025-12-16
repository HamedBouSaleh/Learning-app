<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseProgress;

class CourseProgressController extends Controller
{
    public function index()
    {
        $courseProgresses = CourseProgress::all();
        return response()->json($courseProgresses, 200);
    }

    public function store(Request $request)
    {
        $courseProgress = CourseProgress::create($request->all());
        return response()->json($courseProgress, 201);
    }

    public function show(string $id)
    {
        $courseProgress = CourseProgress::findOrFail($id);
        return response()->json($courseProgress, 200);
    }

    public function update(Request $request, string $id)
    {
        $courseProgress = CourseProgress::findOrFail($id);
        $courseProgress->update($request->all());
        return response()->json($courseProgress, 200);
    }

    public function destroy(string $id)
    {
        CourseProgress::destroy($id);
        return response()->json(null, 204);
    }
}
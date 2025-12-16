<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enrollment;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::all();
        return response()->json($enrollments, 200);
    }

    public function store(Request $request)
    {
        $enrollment = Enrollment::create($request->all());
        return response()->json($enrollment, 201);
    }

    public function show(string $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        return response()->json($enrollment, 200);
    }

    public function update(Request $request, string $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update($request->all());
        return response()->json($enrollment, 200);
    }

    public function destroy(string $id)
    {
        Enrollment::destroy($id);
        return response()->json(null, 204);
    }
}
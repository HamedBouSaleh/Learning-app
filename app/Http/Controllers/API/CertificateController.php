<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificate;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::all();
        return response()->json($certificates, 200);
    }

    public function store(Request $request)
    {
        $certificate = Certificate::create($request->all());
        return response()->json($certificate, 201);
    }

    public function show(string $id)
    {
        $certificate = Certificate::findOrFail($id);
        return response()->json($certificate, 200);
    }

    public function update(Request $request, string $id)
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->update($request->all());
        return response()->json($certificate, 200);
    }

    public function destroy(string $id)
    {
        Certificate::destroy($id);
        return response()->json(null, 204);
    }
}
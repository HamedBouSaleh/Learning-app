<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with(['user', 'course'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $certificates
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'certificate_url' => 'nullable|string|max:255',
            'instructor_name' => 'nullable|string|max:255'
        ]);

        // Generate unique verification code
        $validated['verification_code'] = Str::upper(Str::random(12));

        $certificate = Certificate::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Certificate created successfully',
            'data' => $certificate
        ], Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $certificate = Certificate::with(['user', 'course'])->find($id);

        if (!$certificate) {
            return response()->json([
                'success' => false,
                'message' => 'Certificate not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $certificate
        ], Response::HTTP_OK);
    }

    public function verify($verificationCode)
    {
        $certificate = Certificate::where('verification_code', $verificationCode)
            ->with(['user', 'course'])
            ->first();

        if (!$certificate) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Certificate is valid',
            'data' => $certificate
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $certificate = Certificate::find($id);

        if (!$certificate) {
            return response()->json([
                'success' => false,
                'message' => 'Certificate not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $certificate->delete();

        return response()->json([
            'success' => true,
            'message' => 'Certificate deleted successfully'
        ], Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attachment;

class AttachmentController extends Controller
{
    public function index()
    {
        $attachments = Attachment::all();
        return response()->json($attachments, 200);
    }

    public function store(Request $request)
    {
        $attachment = Attachment::create($request->all());
        return response()->json($attachment, 201);
    }

    public function show(string $id)
    {
        $attachment = Attachment::findOrFail($id);
        return response()->json($attachment, 200);
    }

    public function update(Request $request, string $id)
    {
        $attachment = Attachment::findOrFail($id);
        $attachment->update($request->all());
        return response()->json($attachment, 200);
    }

    public function destroy(string $id)
    {
        Attachment::destroy($id);
        return response()->json(null, 204);
    }
}
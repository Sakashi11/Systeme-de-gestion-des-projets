<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index(Project $project)
    {
        $files = $project->files()->with('uploader')->get();
        return response()->json($files);
    }

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        $uploadedFile = $request->file('file');
        $path = $uploadedFile->store('project-files', 'public');

        $file = $project->files()->create([
            'uploaded_by' => $request->user()->id,
            'name'        => $uploadedFile->getClientOriginalName(),
            'path'        => $path,
            'mime_type'   => $uploadedFile->getMimeType(),
            'size'        => $uploadedFile->getSize(),
        ]);

        return response()->json([
            'message' => 'Fichier uploadé avec succès',
            'file'    => $file->load('uploader'),
        ], 201);
    }

    public function destroy(Request $request, File $file)
    {
        Storage::disk('public')->delete($file->path);
        $file->delete();

        return response()->json([
            'message' => 'Fichier supprimé',
        ]);
    }
}
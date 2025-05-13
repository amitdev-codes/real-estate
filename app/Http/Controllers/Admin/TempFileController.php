<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TempFileController extends Controller
{
    public function tempFileUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]);

        try {
            $file = $request->file('file');

            $filename = now()->timestamp . Str::random(4) . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs('temp/', $file, $filename);

            return response()->json([
                'success' => true,
                'message' => 'Temp File uploaded successfully.',
                'tmp' => $filename,
                'originalName' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'type' => $file->getMimeType(),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ], 500);
        }

    }

    public function tempFileDelete(Request $request)
    {
        $request->validate(['file' => 'required|string']);

        $deleted = Storage::delete('temp/' . $request->file);

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully.',                
            ], 200);
        } 

        return response()->json([
            'success' => false,
            'message' => 'File not found.',
        ], 404);        
    }

    public function fileDelete(Request $request)
    {
        $request->validate(['file' => 'required|string']);

        $media = Media::where('file_name', basename($request->file))->first();


        if (!$media) {
            return response()->json([
                'success' => false,
                'message' => 'Media file not found.',
            ], 404);
        }
    
        try {

            $media->delete();            
            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully.',
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the file.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

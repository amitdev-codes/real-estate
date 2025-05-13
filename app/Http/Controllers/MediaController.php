<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'media.*' => 'required|image|max:5120',
            'model' => 'required|string',
            'collection' => 'required|string',
            'preserve_existing' => 'boolean',
        ]);

        try {
            // dd($request->model);
            $modelClass = $this->resolveModelClass($request->model);
            if (! class_exists($modelClass)) {
                throw new Exception("Model class {$modelClass} not found");
            }
            $idField = $this->getIdFieldForModel($request->model);
            $instance = $modelClass::where($idField, auth()->id())->firstOrFail();
            // $instance = $modelClass::where('user_id', auth()->id())->firstOrFail();
            $results = [];

            if ($request->hasFile('media')) {
                $mediaFiles = $request->file('media');
                if (! is_array($mediaFiles)) {
                    $mediaFiles = [$mediaFiles];
                }

                $results = [];
                foreach ($mediaFiles as $mediaFile) {
                    $media = $instance->addMedia($mediaFile)
                        ->toMediaCollection($request->collection);

                    $results[] = [
                        'url' => $media->getUrl(),
                        'preview_url' => $media->getUrl('preview'),
                        'thumb_url' => $media->getUrl('thumb'),
                        'id' => $media->id,
                        'name' => $media->name,
                    ];
                }

                return response()->json($results);
            }

            return response()->json($results);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function resolveModelClass(string $model): string
    {
        $model = ucfirst(trim($model));

        if (str_contains($model, '\\')) {
            return $model;
        }

        return 'Modules\\'.ucfirst($model).'\\Models\\'.ucfirst($model);
    }

    public function destroy($id)
    {
        try {
            $media = Media::findOrFail($id);

            // Optional: Add authorization check
            if ($media->model->user_id !== auth()->id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            // Delete the media
            $media->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getIdFieldForModel(string $model): string
    {
        // Convert model name to lowercase for comparison
        $model = strtolower($model);

        // Define model-specific ID fields
        $idFields = [
            'user' => 'id',  // For User model, use 'id'
            // Add other models and their ID fields here
            'default' => 'user_id',  // Default fallback
        ];

        return $idFields[$model] ?? $idFields['default'];
    }

    // public function getMediaByCollection(Request $request, $model, $id, $collection)
    // {
    //     try {
    //         // dd($request->all());
    //         $modelClass = $this->resolveModelClass($model);
    //         $instance = $modelClass::findOrFail($id);

    //         return response()->json($instance->getMediaWithUrls($collection));
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }
}

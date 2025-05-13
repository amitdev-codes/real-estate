<?php

namespace App\Traits;

use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasDropzoneMedia
{
    use InteractsWithMedia;

    /**
     * Handle single or multiple file uploads
     * @param mixed $files Single file or array of files
     * @param string $collection Collection name
     * @param bool $preserveExisting Keep existing files
     * @return array
     */
    public function handleMediaUpload($files, string $collection, bool $preserveExisting = false): array
    {
        if (!$preserveExisting) {
            $this->clearMediaCollection($collection);
        }

        $results = [];
        $files = is_array($files) ? $files : [$files];

        foreach ($files as $file) {
            $media = $this->addMedia($file)
                ->withResponsiveImages()
                ->toMediaCollection($collection);

            $media->update(['collection_name' => $collection]);
            $results[] = [
                'id' => $media->id,
                'url' => $media->getUrl(),
                'original_url' => $media->getUrl(),
                'thumb_url' => $media->getUrl('thumb'),
                'preview_url' => $media->getUrl('preview'),
                'name' => $media->name,
                'size' => $media->size,
                'mime_type' => $media->mime_type
            ];
        }

        return $results;
    }

    /**
     * Register media conversions
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10)
            ->nonQueued();

        $this->addMediaConversion('preview')
            ->width(800)
            ->height(800)
            ->sharpen(10)
            ->nonQueued();
    }

    /**
     * Get media items for a collection
     * @param string $collection Collection name
     * @return array
     */
    public function getMediaItems(string $collection): array
    {
        return $this->getMedia($collection)->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => $media->getUrl(),
                'thumb_url' => $media->getUrl('thumb'),
                'preview_url' => $media->getUrl('preview'),
                'name' => $media->name,
                'size' => $media->size,
                'mime_type' => $media->mime_type
            ];
        })->toArray();
    }
}

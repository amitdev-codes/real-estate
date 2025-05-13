<?php

namespace Modules\User\Models;

use App\Models\Address;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'users';

    protected $appends = ['thumb_url', 'preview_url'];

    // Add your model properties and methods here

    public function handleMediaUpload($mediaFiles, $collection, $preserveExisting = false)
    {
        if (! $preserveExisting) {
            $this->clearMediaCollection($collection);
        }

        $results = [];
        foreach ($mediaFiles as $media) {
            $fileAdded = $this->addMedia($media)
                ->toMediaCollection($collection);

            $results[] = [
                'url' => $fileAdded->getUrl(),
                'name' => $fileAdded->name,
                'id' => $fileAdded->id,
            ];
        }

        return $results;
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    // Add accessors for media URLs
    public function getThumbUrlAttribute()
    {
        return $this->getFirstMediaUrl('users', 'thumb') ?: null;
    }

    public function getPreviewUrlAttribute()
    {
        return $this->getFirstMediaUrl('users', 'preview') ?: null;
    }

    // Add method to get all media with URLs for a specific collection
    public function getMediaWithUrls($collection = 'users')
    {
        return $this->getMedia($collection)->map(function (Media $media) {
            return [
                'id' => $media->id,
                'name' => $media->name,
                'file_name' => $media->file_name,
                'mime_type' => $media->mime_type,
                'size' => $media->size,
                'url' => $media->getUrl(),
                'thumb_url' => $media->getUrl('thumb'),
                'preview_url' => $media->getUrl('preview'),
            ];
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('users')->singleFile();
        $this->addMediaCollection('users_images');
    }

    // Define media conversions
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->keepOriginalImageFormat()
            ->fit(Fit::Crop, 80, 80)
            ->sharpen(10)
            ->nonQueued();

        $this->addMediaConversion('preview')
            ->keepOriginalImageFormat()
            ->fit(Fit::Crop, 640, 480)
            ->nonQueued();
    }
}

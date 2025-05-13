<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MetaContent extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $appends = ['thumb_url' ,'preview_url', 'image_path'];

    protected $fillable = [
        'seo_title',
        'seo_description',
        'seo_indexing',
    ];

    public function metaContentable()
    {
        return $this->morphTo();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
    }
    
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->keepOriginalImageFormat()
            ->fit(Fit::Crop, 120, 120)
            ->performOnCollections('images')
            ->nonQueued();

        $this->addMediaConversion('preview')
            ->keepOriginalImageFormat()
            ->fit(Fit::Crop, 600, 800)
            ->performOnCollections('images')
            ->nonQueued();
    }

    public function getPreviewUrlAttribute(){
        return $this->getMedia('images')->map(function ($media) {
            return $media->getUrl('preview');
        });
    }

    public function getThumbUrlAttribute(){
        return $this->getMedia('images')->map(function ($media) {
            return $media->getUrl('thumb');
        });
    }

    public function getImagePathAttribute(){
        return ltrim($this->getFirstMediaUrl('images'), '/');
    }
}

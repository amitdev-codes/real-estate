<?php

namespace Modules\Property\Models;

use id;
use App\Models\Address;
use App\Models\MetaContent;
use Spatie\Image\Enums\Fit;
use Modules\Agency\Models\Agency;
use Spatie\MediaLibrary\HasMedia;
use App\Models\PropertyLengthUnit;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Modules\Property\Database\Factories\ProjectFactory;

class Project extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    protected $casts = [
        'project_categories' => 'json',
        'features' => 'json',
    ];

    protected $appends = ['thumb_url', 'grid', 'preview_url', 'gallery_preview_url', 'hero_image_path', 'image_360_path', 'floor_plan_image_path', 'gallery_image_path', ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->visits = 0;
            $model->created_by_id = auth()->id();
            $model->calculateTotalAreaInMetersSquare();
        });

        static::updating(function ($model) {
            $model->modified_by_id = auth()->id();
            $model->calculateTotalAreaInMetersSquare();
        });
    }

    public function developer()
    {
        return $this->belongsTo(PropertyDeveloper::class, 'developer_id');
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function metaContent()
    {
        return $this->morphOne(MetaContent::class, 'meta_contentable');
    }

    public function projectStatus()
    {
        return $this->belongsTo(ProjectStatus::class, 'project_status_id');
    }

    public function propertyTypes()
    {
        return $this->belongsToMany(PropertyType::class, 'project_property_type');
    }

    public function unit()
    {
        return $this->belongsTo(PropertyLengthUnit::class, 'unit_id');
    }

    public function scopeFeatured($query) {
        return $query->where('is_featured', 1);
    }

    public function scopePublished($query) {
        return $query->where('is_published', 1);
    }

    public function calculateTotalAreaInMetersSquare()
    {
        if ($this->unit) {
            $conversionRate = $this->unit->conversion_rate ?? 1;
            $this->total_area_in_m2 = $this->area * $conversionRate;
        }
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero_image')
            ->singleFile();

        $this->addMediaCollection('image_360')
            ->singleFile();

        $this->addMediaCollection('floor_plan_images');

        $this->addMediaCollection('gallery');
    }

    public function registerMediaConversions(?Media $media = null): void
    {

        $this->addMediaConversion('thumb')
            ->keepOriginalImageFormat()
            ->fit(Fit::Crop, 120, 120)
            ->performOnCollections('hero_image')
            ->nonQueued();

        $this->addMediaConversion('grid')
            ->keepOriginalImageFormat()
            ->fit(Fit::Crop, 80, 80)
            ->performOnCollections('hero_image')
            ->nonQueued();

        $this->addMediaConversion('preview')
            ->keepOriginalImageFormat()
            ->fit(Fit::Crop, 1920, 1080)
            ->performOnCollections('hero_image')
            ->nonQueued();

        $this->addMediaConversion('gallery_thumb')
            ->keepOriginalImageFormat()
            ->fit(Fit::Crop, 120, 120)
            ->performOnCollections('gallery')
            ->nonQueued();

        $this->addMediaConversion('gallery_preview')
            ->keepOriginalImageFormat()
            ->fit(Fit::Crop, 1920, 1080)
            ->performOnCollections('gallery')
            ->nonQueued();
    }

    public function getThumbUrlAttribute()
    {
        return $this->getFirstMediaUrl('hero_image', 'thumb') ?: resource_path('assets/backend/images/error.png');
    }

    public function getPreviewUrlAttribute()
    {
        return $this->getFirstMediaUrl('hero_image', 'preview') ?: resource_path('assets/backend/images/error.png');
    }

    public function getGalleryPreviewUrlAttribute()
    {
        $galleryMedia = $this->getMedia('gallery');

        if ($galleryMedia->isEmpty()) {
            return null;
        }

        return $galleryMedia->map(function ($media) {
            return $media->getFullUrl('gallery_preview');
        })->toArray();
    }

    public function getHeroImagePathAttribute()
    {
        return $this->getFirstMediaUrl('hero_image');
    }

    public function getImage360PathAttribute()
    {
        return $this->getFirstMediaUrl('image_360');
    }
    public function getFloorPlanImagePathAttribute()
    {
        return $this->getMedia('floor_plan_images')->map(function ($media) {
            return $media->original_url;
        });
    }

    public function getGalleryImagePathAttribute(){
        return $this->getMedia('gallery')->map(function ($media) {
            return $media->original_url;
        });
    }

    public function getGridAttribute()
    {
        return $this->getFirstMediaUrl('grid') ?: resource_path('assets/backend/images/error.png');
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'project_id');
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class)->with('agents');
    }

}

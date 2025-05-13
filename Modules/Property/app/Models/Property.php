<?php

namespace Modules\Property\Models;

use App\Models\Address;
use App\Models\MetaContent;
use Spatie\Image\Enums\Fit;
use Illuminate\Support\Carbon;
use Modules\Agent\Models\Agent;
use Modules\Agency\Models\Agency;
use Spatie\MediaLibrary\HasMedia;
use App\Models\PropertyLengthUnit;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Modules\Shortlist\Models\Shortlist;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Property extends Model implements HasMedia
{
    use HasRoles, HasFactory, InteractsWithMedia, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    protected $casts = [
        'features' => 'json',
        'custom_fields' => 'json',
    ];

    protected $appends = ['thumb_url', 'grid', 'preview_url', 'gallery_preview_url', 'hero_image_path', 'image_360_path', 'floor_plan_image_path', 'gallery_image_path',];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $user = Auth::user();

            $model->visits = 0;
            $model->calculateTotalAreaInMetersSquare();
            $model->moderation_status = 'pending';
            // $model->created_by_id = 1;

            // $model->created_by_id = Auth::id();
            if (isset($user) && $user->hasRole('Agent')) {
                $model->created_by_id = $user->agent->id; // Assuming the agent relationship exists
            } elseif (isset($user) && $user->hasRole('Agency')) {
                $model->created_by_id = $user->agency->id; // Assuming the agency relationship exists
            } else {
                $model->created_by_id = 1; // Fallback to the user's ID
            }
        });

        static::updating(function ($model) {
            $user = Auth::user();
            $model->calculateTotalAreaInMetersSquare();
            // $model->modified_by_id = Auth::id();
            if ($user->hasRole('Agent')) {
                $model->modified_by_id = $user->agent->id; // Assuming the agent relationship exists
            } elseif ($user->hasRole('Agency')) {
                $model->modified_by_id = $user->agency->id; // Assuming the agency relationship exists
            } else {
                $model->modified_by_id = 1; // Fallback to the user's ID
            }
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    public function propertyStatus()
    {
        return $this->belongsTo(PropertyStatus::class, 'property_status_id');
    }

    public function propertyTypes()
    {
        return $this->belongsToMany(PropertyType::class, 'property_property_type');
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function nearbyFacilities()
    {
        return $this->hasMany(NearbyFacilityPropertyDistance::class, 'property_id');
    }

    public function facilities()
    {
        return $this->belongsToMany(NearbyFacility::class, 'nearby_facility_property_distances')
            ->withPivot(['distance', 'unit_id'])
            ->withTimestamps()
            ->withTrashed();
    }

    public function metaContent()
    {
        return $this->morphOne(MetaContent::class, 'meta_contentable');
    }

    public function unit()
    {
        return $this->belongsTo(PropertyLengthUnit::class, 'unit_id');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', 1);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'title',
            'description',
            'short_description',
            'area',
            'base_price',
            'offer_price',
            'features'
        ])->useLogName('Property')
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
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
    public function getGalleryImagePathAttribute()
    {
        return $this->getMedia('gallery')->map(function ($media) {
            return $media->original_url;
        });
    }

    public function shortlists(): MorphMany
    {
        return $this->morphMany(Shortlist::class, 'shortlistable');

    }

    public function getGridAttribute()
    {
        return $this->getFirstMediaUrl('grid') ?: resource_path('assets/backend/images/error.png');
    }

    public function category()
    {
        return $this->belongsTo(PropertyCategory::class, 'category_id');
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}

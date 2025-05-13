<?php

namespace Modules\Agent\Models;

use App\Models\User;
use App\Models\Address;
use App\Models\MetaContent;
use Spatie\Image\Enums\Fit;
use App\Traits\HasDropzoneMedia;
use Modules\Agency\Models\Agency;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use App\Models\PersonalInformation;
use Modules\Property\Models\Property;
use Illuminate\Database\Eloquent\Model;
use Modules\Shortlist\Models\Shortlist;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Agent\Database\Factories\AgentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Agent extends Model implements HasMedia
{
    use HasDropzoneMedia, HasFactory,InteractsWithMedia;

    protected $table='agents';

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    protected static function newFactory(): AgentFactory
    {
        //return AgentFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }
    public function personalInformation()
    {
        return $this->morphOne(PersonalInformation::class, 'informable');
    }


    public function metaContent()
    {
        return $this->morphOne(MetaContent::class, 'meta_contentable');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('agents')->singleFile();
        $this->addMediaCollection('agents_testimonials');
    }

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

    // get thumb url and preview url
    public function getThumbUrlAttribute()
    {
        // return $this->getFirstMediaUrl('agents', 'thumb') ?: resource_path('assets/backend/images/no_image.jpg');
        return $this->getFirstMediaUrl('agents', 'thumb') ?: asset('static/images/no_image.jpg');
    }

    public function getPreviewUrlAttribute()
    {
        // return $this->getFirstMediaUrl('agents', 'preview') ?: resource_path('assets/backend/images/no_image.jpg');
        return $this->getFirstMediaUrl('agents', 'preview') ?: asset('static/images/no_image.jpg');
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function getPropertyStatistics()
    {
        if (! $this->exists) {  // Assuming you're using a role system
            return [
                'total_visits' => 0,
                'total_properties' => 0,
                'approved_properties' => 0,
                'pending_properties' => 0,
                'rejected_properties' => 0,
            ];
        }

        return [
            'total_visits' => $this->properties->sum('visits') ?? 0,
            'total_properties' => $this->properties()->count(),
            'approved_properties' => $this->properties()
                ->where('moderation_status', 'approved')->count(),
            'pending_properties' => $this->properties()
                ->where('moderation_status', 'pending')->count(),
            'rejected_properties' => $this->properties()
                ->where('moderation_status', 'rejected')->count(),
        ];
    }

    protected $casts = [
        'additional_areas' => 'array',
        'specializations' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['first_name', 'last_name', 'user_id', 'agency_id','phone','license_number'])->useLogName('Agent')
            ->setDescriptionForEvent(fn (string $eventName) => "This model has been {$eventName}");
    }

    public function shortlists()
    {
        return $this->morphMany(Shortlist::class, 'shortlistable');
    }
}

<?php

namespace Modules\Agency\Models;

use App\Models\User;
use App\Models\Address;
use App\Models\MetaContent;
use Spatie\Image\Enums\Fit;
use Modules\Agent\Models\Agent;
use App\Traits\HasDropzoneMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use App\Models\PersonalInformation;
use Modules\Property\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Modules\Shortlist\Models\Shortlist;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Agency\Database\Factories\AgencyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Agency extends Model implements HasMedia
{
    use HasDropzoneMedia,HasFactory, InteractsWithMedia;

    protected $appends = ['thumb_url','preview_url'];
    protected $table='agencies';

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    protected static function newFactory(): AgencyFactory
    {
        //return AgencyFactory::new();
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
        $this->addMediaCollection('agency')->singleFile();
        $this->addMediaCollection('agency_testimonials');
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
        return $this->getFirstMediaUrl('agency', 'thumb') ?: resource_path('assets/backend/images/error.png');
    }

    public function getPreviewUrlAttribute()
    {
        return $this->getFirstMediaUrl('agency', 'preview') ?: resource_path('assets/backend/images/error.png');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['name', 'slug', 'description', 'email','agency_id'])->useLogName('Agency')
            ->setDescriptionForEvent(fn (string $eventName) => "This model has been {$eventName}");
    }
    public function agents()
    {
        return $this->hasMany(Agent::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    public function shortlists()
    {
        return $this->morphMany(Shortlist::class, 'shortlistable');
    }
}

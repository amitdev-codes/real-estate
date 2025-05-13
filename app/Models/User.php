<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\Models\Address;
use Spatie\Image\Enums\Fit;
use Modules\Agent\Models\Agent;
use Modules\Agency\Models\Agency;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use App\Models\PersonalInformation;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, HasRoles, InteractsWithMedia;
    use LogsActivity;

    protected $appends = ['thumb_url', 'preview_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'mobile_no',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean',
        ];
    }

    protected static $logName = 'User';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['name', 'email', 'mobile_no', 'password'])->useLogName('User')
            ->setDescriptionForEvent(fn (string $eventName) => "This model has been {$eventName}");
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }
    public function personalInformation()
    {
        return $this->morphOne(PersonalInformation::class, 'informable');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('users')->singleFile();
        $this->addMediaCollection('users_images');
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
    // public function getThumbUrlAttribute()
    // {
    //     return $this->getFirstMediaUrl('images', 'thumb') ?: resource_path('assets/backend/images/error.png');
    // }

    // public function getPreviewUrlAttribute()
    // {
    //     return $this->getFirstMediaUrl('images', 'preview') ?: resource_path('assets/backend/images/error.png');
    // }

    public function getThumbUrlAttribute()
    {
        return $this->getFirstMediaUrl('users', 'thumb') ?: resource_path('assets/backend/images/error.png');
    }

    public function getPreviewUrlAttribute()
    {
        return $this->getFirstMediaUrl('users', 'preview') ?: resource_path('assets/backend/images/error.png');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d');
    }

    public function getRoleNamesLowercaseAttribute()
    {
        return $this->getRoleNames()->map(function ($role) {
            return strtolower($role);
        });
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('mobile_no', 'like', "%$search%");
        });
    }

    public function agent()
    {
        return $this->hasOne(Agent::class);
    }

    public function agency()
    {
        return $this->hasOne(Agency::class);
    }

    public function shortlists()
    {
        return $this->hasMany(Shortlist::class);
    }

    public function savedSearches()
    {
        return $this->hasMany(SavedSearch::class);
    }

    public function inspectionPlans()
    {
        return $this->hasMany(InspectionPlan::class);
    }

    public function preferences()
    {
        return $this->hasOne(UserPreference::class);
    }
}

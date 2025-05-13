<?php

namespace App\Models\master;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Country extends Model
{
    use HasFactory,LogsActivity;
    use SoftDeletes;

    protected $table = 'countries';

    protected $guarded = [];

    public function hasState(): hasMany
    {
        return $this->hasMany(State::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['name', 'code'])->useLogName('Country')
            ->setDescriptionForEvent(fn (string $eventName) => "This model has been {$eventName}");
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d');
    }
}

<?php

namespace App\Models\master;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class City extends Model
{
    use HasFactory,LogsActivity;
    use SoftDeletes;

    protected $guarded = [];

    public function State(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['name', 'code'])->useLogName('city')
            ->setDescriptionForEvent(fn (string $eventName) => "This model has been {$eventName}");
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d');
    }
}

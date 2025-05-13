<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyLengthUnit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['name', 'description'])->useLogName('Property Length Unit')
            ->setDescriptionForEvent(fn (string $eventName) => "This model has been {$eventName}");
    }
}

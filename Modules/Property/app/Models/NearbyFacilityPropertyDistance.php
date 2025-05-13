<?php

namespace Modules\Property\Models;

use App\Models\PropertyLengthUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Property\Database\Factories\NearbyFacilityPropertyDistanceFactory;

class NearbyFacilityPropertyDistance extends Model
{
    use HasFactory;

    protected $fillable = ['property_id', 'nearby_facility_id', 'distance', 'unit_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->calculateTotalDistanceInMeters();
        });

        static::updating(function ($model) {
            $model->calculateTotalDistanceInMeters();
        });
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function nearbyFacility()
    {
        return $this->belongsTo(NearbyFacility::class);
    }

    public function unit()
    {
        return $this->belongsTo(PropertyLengthUnit::class, 'unit_id');
    }

    public function calculateTotalDistanceInMeters()
    {
        if ($this->unit) {
            $conversionRate = $this->unit->conversion_rate ?? 1;
            $this->total_area_in_m = $this->distance * $conversionRate;
        }
    }
}

<?php

namespace Modules\Property\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Property\Database\Factories\NearbyFacilityFactory;

class NearbyFacility extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'icon', 'description', 'is_active'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->order_no = static::max('id') + 1;
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // if property search/filter is done with facility distance in the future
    // public function properties()
    // {
    //     return $this->belongsToMany(Property::class, 'nearby_facility_property_distances')
    //         ->withPivot('distance', 'unit_id')
    //         ->using(NearbyFacilityPropertyDistance::class);
    // }
}

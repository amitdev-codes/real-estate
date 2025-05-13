<?php

namespace Modules\Property\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyFacilitiesDistance extends Model
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
}


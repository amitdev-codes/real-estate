<?php

namespace Modules\Property\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Property\Database\Factories\PropertyPurposeFactory;

class PropertyPurpose extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'is_active'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->order_no = static::max('id') + 1;
        });
    }
}

<?php

namespace Modules\Property\Models;

use App\Models\Address;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Property\Database\Factories\PropertyDeveloperFactory;

class PropertyDeveloper extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];



    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

}



<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class PropertyEnquiry extends Model
{
    protected $guarded = [

    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
        'enquiry_type_id' => 'array'
    ];
}

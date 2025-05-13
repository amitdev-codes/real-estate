<?php

namespace Modules\Shortlist\Models;

use App\Models\User;
use Modules\Agent\Models\Agent;
use Modules\Agency\Models\Agency;
use Modules\Property\Models\Property;
use Illuminate\Database\Eloquent\Model;

// use Modules\Shortlist\Database\Factories\ShortlistFactory;

class Shortlist extends Model
{
    protected $fillable = [
        'user_id',
        'shortlistable_id',
        'shortlistable_type',
        'agent_id',
        'agency_id',
        'property_id',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shortlistable()
    {
        return $this->morphTo();
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}

<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class SavedSearch extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shortlistable()
    {
        return $this->morphTo();
    }
}

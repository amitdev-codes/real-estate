<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Shortlist extends Model
{
    protected $fillable = ['user_id', 'shortlistable_id', 'shortlistable_type', 'notes'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shortlistable()
    {
        return $this->morphTo();
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    protected $table = 'personal_informations';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'website',
        'business_phone_number',
        'business_email',
        'informable_id',
        'informable_type',
        'bio'
    ];
    public function getFormattedDateOfBirthAttribute()
    {
        return Carbon::parse($this->date_of_birth)->format('jS F, Y');
    }
    /**
     * Get the parent informable model (e.g., User).
     */
    public function informable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

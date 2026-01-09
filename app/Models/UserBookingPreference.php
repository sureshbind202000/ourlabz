<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBookingPreference extends Model
{
    protected $fillable = [
        'user_id',
        'preferred_test_type',
        'preferred_lab_clinic',
        'preferred_date_time',
        'sample_collecton_mode',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

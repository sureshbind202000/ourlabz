<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    protected $fillable = [
        'user_id',
        'address',
        'city',
        'state',
        'country',
        'pin',
        'google_map_location',
        'alternate_phone',
        'emergency_contact_name',
        'emergency_contact_phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

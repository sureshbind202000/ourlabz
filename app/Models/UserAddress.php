<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'address',
        'city',
        'state',
        'country',
        'pin',
        'google_map_location',
        'type',
        'latitude',
        'longitude'
    ];
}

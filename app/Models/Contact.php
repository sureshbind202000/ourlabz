<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'about',
        'office_address',
        'phone',
        'email',
        'facebook',
        'twitter',
        'linkedin',
        'youtube',
        'map_address',
    ];

    protected $casts = [
        'phone' => 'array',
        'email' => 'array',
    ];
}

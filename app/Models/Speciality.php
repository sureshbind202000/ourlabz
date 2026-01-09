<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    protected $fillable = [
        'slug',
        'image',
        'speciality',
        'short_order',
        'status',
    ];
}

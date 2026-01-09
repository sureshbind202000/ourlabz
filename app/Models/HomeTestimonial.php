<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeTestimonial extends Model
{
    protected $fillable = [
        'name',
        'title',
        'image',
        'rating',
        'message',
        'sort_order',
        'is_active',
    ];
}

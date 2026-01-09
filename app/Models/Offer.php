<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'type',
        'title',
        'content',
        'image',
        'link',
        'timer_end_at',
        'is_active',
        'sort_order',
        'page',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'timer_end_at' => 'datetime',
        'sort_order'   => 'integer',
    ];
}

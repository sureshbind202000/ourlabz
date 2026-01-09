<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeVideo extends Model
{
    protected $fillable = [
        'title',
        'content',
        'link',
        'popup_link',
        'sort_order',
        'is_active',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeBrand extends Model
{
    protected $fillable = [
        'name',
        'image',
        'link',
        'sort_order',
        'is_active',
    ];
}

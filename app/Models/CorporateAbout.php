<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorporateAbout extends Model
{
    protected $fillable = [
        'image',
        'title',
        'heading',
        'content'
    ];
}

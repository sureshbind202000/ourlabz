<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorporateBanner extends Model
{
    protected $fillable = [
        'name',
        'image',
        'heading',
        'heading2',
        'heading3',
        'paragraph',
        'button_text',
        'button_link',
        'button_text2',
        'button_link2',
        'sort',
        'status',
    ];
}

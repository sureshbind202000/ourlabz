<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabSlider extends Model
{
    protected $fillable = [
        'lab_id',
        'name',
        'image',
        'is_active'
    ];
}

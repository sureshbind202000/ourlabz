<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorporateDoctorConsult extends Model
{
    protected $fillable = [
        'image',
        'title',
        'content'
    ];
}

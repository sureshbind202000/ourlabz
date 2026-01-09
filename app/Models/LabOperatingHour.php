<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabOperatingHour extends Model
{
    protected $fillable = [
        'lab_id',
        'day',
        'from_time',
        'to_time',
        'status'
    ];
}

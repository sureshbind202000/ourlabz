<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorOperatingHour extends Model
{
    protected $fillable = [
        'doctor_id',
        'day',
        'from_time',
        'to_time',
        'status'
    ];
}

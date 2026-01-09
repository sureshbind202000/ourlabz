<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSignature extends Model
{
    protected $fillable = [
        'doctor_id',
        'signature',
    ];
}

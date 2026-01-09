<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMedicalInformation extends Model
{
    protected $fillable = [
        'user_id',
        'medical_condition',
        'allergies',
        'current_medications',
        'family_doctor_name_contact',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
      protected $fillable = [
        'doctor_consultation_id',
        'written_prescription',
        'file_prescription',
    ];
    public function consultation()
    {
        return $this->belongsTo(DoctorConsultation::class, 'doctor_consultation_id');
    }
}

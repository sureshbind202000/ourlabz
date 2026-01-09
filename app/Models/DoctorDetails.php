<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorDetails extends Model
{
    protected $fillable = [
        'doctor_id',
        'about',
        'medical_license_number',
        'license_issue_authority',
        'specialization',
        'qualification',
        'year_of_experience',
        'affiliated_hospital_clinic_name',
        'hospital_clinic_address',
        'consultation_type',
        'account_number',
        'ifsc_code',
        'account_holder_name',
        'upi_id',
        'tin',
        'medical_degree_certificate',
        'medical_license',
        'id_proof',
        'id_type',
        'price',
        'status',
    ];

    protected $casts = [
        'specialization' => 'array',
        'qualification' => 'array',
    ];
}

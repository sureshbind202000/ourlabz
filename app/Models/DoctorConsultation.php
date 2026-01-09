<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorConsultation extends Model
{
    protected $fillable = [
        'user_id',
        'doctor_id',
        'address_id',
        'consultation_type',
        'doctor_written_prescription',
        'doctor_uploaded_prescription',
        'prescription_upload',
        'appointment_date',
        'appointment_time',
        'meeting_url',
        'meeting_id',
        'payment_id',
        'referred_to',
        'booking_test_id',
        'cancel_reason',
        'cancelled_by',
        'cancelled_at',
        'refund_amount',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'address_id');
    }
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'doctor_consultation_id');
    }
    public function referred()
    {
        return $this->hasOne(ReferredConsultation::class, 'referred_consultation');
    }
    public function activityLogs()
    {
        return $this->hasMany(DoctorConsultationLog::class, 'consultation_id')->orderBy('created_at', 'desc');
    }
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'user_id');
    }
}

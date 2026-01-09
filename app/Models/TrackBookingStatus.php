<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackBookingStatus extends Model
{
    protected $fillable = [
        'tracking_id',
        'booking_patient_id',
        'status',
        'title',
        'otp',
        'otp_verified_at',
        'collection_status'
    ];

    public function patient()
    {
        return $this->belongsTo(BookingPatient::class, 'booking_patient_id');
    }

    public function trackSample()
    {
        return $this->hasOne(TrackSample::class, 'patient_id', 'booking_patient_id');
    }
}

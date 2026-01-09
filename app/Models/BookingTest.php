<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingTest extends Model
{
    protected $fillable = [
        'booking_id',
        'booking_patient_id',
        'package_id',
        'price_at_booking_time',
        'report_type',
        'report_file',
        'verify',
        'verify_id',
        'certify',
        'certify_id',
        'fwd_id',
        'free_consultation',
        'status',
    ];

    public function package()
    {
        return $this->belongsTo(package::class, 'package_id', 'package_id');
    }

    public function patient()
    {
        return $this->belongsTo(BookingPatient::class, 'booking_patient_id');
    }

     public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}

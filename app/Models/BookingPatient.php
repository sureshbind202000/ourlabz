<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingPatient extends Model
{
    protected $fillable = [
        'booking_id',
        'user_id',
        'name',
        'gender',
        'phone',
        'email',
        'dob',
        'age',
        'relation',
        'prescription',
    ];

    public function trackBooking()
    {
        return $this->hasOne(TrackBookingStatus::class, 'booking_patient_id', 'id');
    }

    public function test()
    {
        return $this->hasOne(BookingTest::class, 'booking_patient_id');
    }
}

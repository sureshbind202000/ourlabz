<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackSample extends Model
{
    protected $fillable = [
        'booking_id',
        'order_id',
        'user_id',
        'patient_id',
        'test_id',
        'agent_id',
        'note',
        'status',
        'sample_image',
        'reason',
        'tracking_id',
    ];

    protected $casts = [
        'sample_image' => 'array',
    ];

    public function bookingTest()
    {
        return $this->belongsTo(BookingTest::class, 'test_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function booking_patient()
    {
        return $this->belongsTo(BookingPatient::class, 'patient_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function phlebotomist()
    {
        return $this->belongsTo(User::class, 'agent_id','user_id');
    }

    public function logs()
    {
        return $this->hasMany(TrackBookingLog::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'booking_type',
        'lab_id',
        'booking_date',
        'time_slot',
        'address',
        'status',
        'payment_status',
        'sample_collection',
        'notes',
        'sub_total',
        'discount',
        'shipping',
        'tax',
        'total_amount',
        'order_id',
        'track_status',
        'cancel_reason',
        'cancelled_by',
        'cancelled_at',
        'refund_amount',
    ];

    // A booking belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // A booking has many patients
    public function patients()
    {
        return $this->hasMany(BookingPatient::class, 'booking_id');
    }

    // A booking has many tests
    public function tests()
    {
        return $this->hasMany(BookingTest::class, 'booking_id');
    }

    // A booking belongs to an address
    public function bookingAddress()
    {
        return $this->belongsTo(UserAddress::class, 'address');
    }

    // A booking has many sample tracking records
    public function trackSamples()
    {
        return $this->hasMany(TrackSample::class, 'booking_id');
    }
}

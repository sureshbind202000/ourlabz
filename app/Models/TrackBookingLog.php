<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackBookingLog extends Model
{
    protected $fillable = ['booking_id', 'action', 'description', 'performed_by'];

    public function sample()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}

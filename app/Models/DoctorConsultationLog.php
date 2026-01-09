<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class DoctorConsultationLog extends Model
{
    protected $fillable = [
        'consultation_id',
        'user_id',
        'action',
        'description'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)
            ->timezone('Asia/Kolkata')  // Convert to IST
            ->format('d M Y, h:i A');   // e.g., 16 Dec 2025, 07:21 AM
    }
}

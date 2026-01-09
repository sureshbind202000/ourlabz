<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorReview extends Model
{
    protected $fillable = [
        'doctor_id',
        'name',
        'email',
        'rating',
        'comment',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}

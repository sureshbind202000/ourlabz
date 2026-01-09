<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInsurancePayment extends Model
{
    protected $fillable = [
        'user_id',
        'insurance_provider',
        'insurance_policy_number',
        'payment_preference',
        'discount_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

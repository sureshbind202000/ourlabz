<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'type',
        'subtotal',
        'coupon',
        'discount',
        'discount_type',
        'shipping',
        'tax',
        'total',
        'payment_mode',
        'order_id',
        'transaction_id',
        'payment_status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

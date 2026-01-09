<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'vendor_id',
        'order_number',
        'address_id',
        'subtotal',
        'shipping_cost',
        'discount',
        'tax',
        'total',
        'payment_method',
        'status',
        'notes',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function trackingStatuses()
    {
        return $this->hasMany(OrderTrackingStatus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id')->where('role', 5);
    }
}

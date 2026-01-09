<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id', 
        'vendor_id',
        'price',
        'shipping_cost',
        'quantity',
        'total',
        'shiprocket_shipment_id',
        'cancel_reason',
        'cancelled_by',
        'cancelled_at',
        'refund_amount',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

     public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id')->where('role', 5);
    }
}

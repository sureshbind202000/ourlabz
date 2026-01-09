<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTrackingStatus extends Model
{
    protected $fillable = [
        'order_id',
        'status',
        'title',
        'updated_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

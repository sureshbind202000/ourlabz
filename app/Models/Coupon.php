<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'discount_type',
        'discount_value',
        'max_discount',
        'buy_qty',
        'get_qty',
        'get_item_id',
        'get_item_model',
        'min_cart_amount',
        'applicable_categories',
        'applicable_products',
        'for_lab_tests',
        'for_products',
        'for_doctors',
        'usage_limit',
        'usage_per_user',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'applicable_categories' => 'array',
        'applicable_products' => 'array',
        'for_lab_tests' => 'boolean',
        'for_products' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Relationship: coupon used by many users
    public function users()
    {
        return $this->belongsToMany(User::class, 'coupon_user')
            ->withPivot('used_count', 'order_id')
            ->withTimestamps();
    }

    // Check if coupon is active
    public function isActive()
    {
        if (!$this->is_active) return false;

        $now = Carbon::now();
        return ($this->start_date == null || $now >= $this->start_date)
            && ($this->end_date == null || $now <= $this->end_date);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorporatePackage extends Model
{
    protected $fillable = [
        'p_id',
        'corporate_id',
        'package_ids',
        'test_ids',
        'name',
        'no_of_employee',
        'price',
        'discount_type',
        'discount',
        'total_price',
        'coupon',
    ];

    protected $casts = [
        'package_ids' => 'array',
        'test_ids' => 'array',
    ];

    public function corporateAdmin()
    {
        return $this->belongsTo(User::class, 'corporate_id', 'id')
            ->where('role', 4);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'id')
            ->where('type', 'Corporate Package');
    }
}

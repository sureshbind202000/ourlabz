<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAdditionalDetail extends Model
{
    protected $fillable = [
        'product_id',
        'label',
        'property',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

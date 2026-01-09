<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVarient extends Model
{
    protected $fillable = [
        'product_id',
        'varient_id',
        'varient_name',
        'variation_values',
        'attributes',
        'product_identification_no',
        'regular_price',
        'discount',
        'discount_type',
        'selling_price',
        'bulk_regular_price',
        'bulk_discount',
        'bulk_discount_type',
        'bulk_selling_price',
        'bulk_moq',
        'release_date',
        'warranty',
        'stock',
        'in_stock',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'attributes' => 'array',
        'variation_values' => 'array',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'varient_id');
    }

    public function attributeValues()
    {
        // variation_values is a JSON array of IDs
        $ids = $this->variation_values ?? [];
        return ProductAttributeValue::whereIn('id', $ids)->get();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

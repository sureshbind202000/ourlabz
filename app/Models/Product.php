<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'vendor_id',
        'product_id',
        'slug',
        'product_name',
        'varient',
        'brand',
        'product_identification_no',
        'short_desc',
        'long_desc',
        'type',
        'category',
        'sub_category',
        'regular_price',
        'discount',
        'discount_type',
        'selling_price',
        'bulk_regular_price',
        'bulk_discount',
        'bulk_discount_type',
        'bulk_selling_price',
        'bulk_moq',
        'country_of_origin',
        'release_date',
        'warranty',
        'shipping',
        'weight',
        'tags',
        'stock',
        'in_stock',
        'product_for',
        'status',
        'rejection_reason',
    ];

    public function banners()
    {
        return $this->hasMany(Banner::class, 'product_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVarient::class, 'product_id', 'id');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'type');
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'category');
    }

    public function productSubCategory()
    {
        return $this->belongsTo(ProductSubCategory::class, 'sub_category');
    }

    public function specifications()
    {
        return $this->hasMany(ProductAdditionalDetail::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function additionalDetails()
    {
        return $this->hasOne(ProductAdditionalDetail::class);
    }
    public function reviews()
    {
        return $this->hasMany(ProductReview::class)->where('is_active', 1);
    }
    // Accessor for average rating
    public function getAverageRatingAttribute()
    {
        $avg = $this->reviews->avg('rating');
        return $avg && $avg > 0 ? round($avg, 1) : rand(3, 5);
    }

    // Accessor for total review count
    public function getReviewCountAttribute()
    {
        return $this->reviews->count();
    }
}

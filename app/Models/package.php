<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class package extends Model
{
    protected $fillable = [
        'package_id',
        'category',
        'name',
        'package_icon',
        'department_category',
         'slug',
        'about_test',
        'list_of_parameters_note',
        'test_preparation',
        'why_this_test',
        'interpretations',
        'measures',
        'identifies',
        'sample_type_specimen',
        'tat',
        'recommendation_of_age',
        'stability_room',
        'stability_refrigerated',
        'stability_frozen',
        'method',
        'reports_within',
        'regular_price',
        'discount_type',
        'discount_price',
        'price',
        'type',
        'corporate_regular_price',
        'corporate_discount_type',
        'corporate_discount',
        'corporate_price',
        'is_prescription',
        'free_consultation',
        'consultant_category',
        'status',
        'is_draft'
    ];

    protected $casts = [
        'consultant_category' => 'array',
    ];

    public function requisites()
    {
        return $this->hasMany(packageRequisites::class, 'package_id');
    }

    public function parameters()
    {
        return $this->hasMany(packageListOfParameter::class, 'package_id');
    }

    public function faqs()
    {
        return $this->hasMany(packageFaq::class, 'package_id');
    }

    public function categoryDetails()
    {
        return $this->belongsTo(PackageCategory::class, 'category');
    }

    public function packageReviews()
    {
        return $this->hasMany(PackageReview::class, 'package_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($package) {
            $package->requisites()->delete();
            $package->parameters()->delete();
            $package->faqs()->delete();
        });
    }

    public function getSellingPriceAttribute()
    {
        $isCorporate = auth()->check() && auth()->user()->corporate_id !== null;

        $regular = $isCorporate ? $this->corporate_regular_price : $this->regular_price;
        $discount = $isCorporate ? $this->corporate_discount : $this->discount_price;
        $type = $isCorporate ? $this->corporate_discount_type : $this->discount_type;

        $price = $regular;

        if ($discount && $type === 'percent') {
            $price = $regular - ($regular * $discount) / 100;
        } elseif ($discount && $type === 'flat') {
            $price = $regular - $discount;
        }

        return $price;
    }

    public function getDiscountLabelAttribute()
    {
        $isCorporate = auth()->check() && auth()->user()->corporate_id !== null;

        $discount = $isCorporate ? $this->corporate_discount : $this->discount_price;
        $type = $isCorporate ? $this->corporate_discount_type : $this->discount_type;

        if ($discount && $type === 'percent') {
            return $discount . '% Off';
        } elseif ($discount && $type === 'flat') {
            return '₹' . number_format($discount, 0) . ' Off';
        }

        return null;
    }

    public function getRegularPriceAttribute($value)
    {
        return auth()->check() && auth()->user()->corporate_id !== null
            ? $this->corporate_regular_price
            : $value;
    }
}

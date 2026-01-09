<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends Model
{
    protected $fillable = [
        'slug',
        'category_id',
        'name',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function type()
    {
        // Access type through category
        return $this->hasOneThrough(ProductType::class, ProductCategory::class, 'id', 'id', 'category_id', 'type_id');
    }
}

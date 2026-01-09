<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'slug',
        'type_id',
        'name',
    ];

    public function type()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function subCategories()
    {
        return $this->hasMany(ProductSubCategory::class);
    }
}

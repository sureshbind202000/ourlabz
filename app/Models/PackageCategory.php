<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageCategory extends Model
{
    protected $fillable = [
        'slug',
        'type',
        'category_image',
        'category_name',
        'status',
        'sort',
    ];

    public function packages()
    {
        return $this->hasMany(Package::class, 'category');
    }
}

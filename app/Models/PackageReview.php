<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageReview extends Model
{
    protected $fillable = [
        'package_id',
        'name',
        'email',
        'rating',
        'comment',
        'is_active',
    ];

    public function package()
    {
        return $this->belongsTo(package::class, 'package_id');
    }
}

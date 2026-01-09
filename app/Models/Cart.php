<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'item_type',
        'item_id',
        'quantity',
        'patients_id',
    ];

    protected $casts = [
        'patients_id' => 'array',
    ];

    public function item()
    {
        return $this->morphTo(__FUNCTION__, 'item_type', 'item_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'item_id');
    }

}

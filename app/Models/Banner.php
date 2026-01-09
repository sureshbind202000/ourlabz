<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'name',
        'image',
        'tag',
        'heading',
        'heading2',
        'heading3',
        'paragraph',
        'button_text',
        'button_link',
        'button_text2',
        'button_link2',
        'sort',
        'status',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

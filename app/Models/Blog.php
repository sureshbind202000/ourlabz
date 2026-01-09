<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'author',
        'thumbnail_image',
        'short_content',
        'image',
        'content',
        'is_active',
        'views',
        'likes',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'tags',
    ];

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'blog_id');
    }
}

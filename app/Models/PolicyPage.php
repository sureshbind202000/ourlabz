<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PolicyPage extends Model
{
    use HasFactory;

    protected $table = 'policy_pages';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
    ];

    /**
     * Automatically generate slug if not provided
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });

        static::updating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    /**
     * Scope: Active policy pages
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}

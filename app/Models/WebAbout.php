<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebAbout extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'web_abouts';

    // Mass assignable attributes
    protected $fillable = [
        'heading',
        'about_content',
        'primary_image',
        'secondary_image',
        'experience_years',
        'keypoints',    // JSON array
        'link',
        'total_sales',
        'happy_clients',
        'team_workers',
        'win_awards',
    ];

    // Casts
    protected $casts = [
        'keypoints' => 'array',
    ];
}

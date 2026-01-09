<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorporateHospitalAssistance extends Model
{
    protected $fillable = [
        'image',
        'title',
        'heading',
        'content',
        'heading2',
        'content2',
        'card_image1',
        'card_image2',
        'card_image3',
        'card_title1',
        'card_title2',
        'card_title3',
        'card_content1',
        'card_content2',
        'card_content3',
    ];
}

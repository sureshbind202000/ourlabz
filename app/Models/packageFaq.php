<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class packageFaq extends Model
{
    protected $table = "package_faqs";
    
    protected $fillable = [
        'package_id',
        'question',
        'answer',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportLayout extends Model
{
     protected $fillable = [
        'lab_id', 'logo', 'header', 'footer', 'signature', 'status'
    ];
}

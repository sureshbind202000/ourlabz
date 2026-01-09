<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class packageListOfParameter extends Model
{
    protected $fillable = [
        'package_id',
        'name',
        'content',
        'no_of_parameter',
    ];
}

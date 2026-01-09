<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class packageRequisites extends Model
{
    protected $fillable = [
        'package_id',
        'icon',
        'name',
    ];
}

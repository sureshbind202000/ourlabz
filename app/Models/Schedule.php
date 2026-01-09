<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'scheduler_id',
        'scheduling_for',
        'day',
        'date',
        'from_time',
        'to_time',
        'slots',
        'status',
    ];
}

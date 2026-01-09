<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabReview extends Model
{
    protected $fillable = [
        'lab_id',
        'name',
        'email',
        'rating',
        'comment',
        'is_active',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'lab_id');
    }
}

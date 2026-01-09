<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferredConsultation extends Model
{
    public function referredToUser()
    {
        return $this->belongsTo(User::class, 'referred_to');
    }
}

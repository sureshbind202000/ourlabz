<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDocuments extends Model
{
    protected $fillable = [
        'user_id',
        'id_proof',
        'id_proof_type',
        'insurance_card',
        'doctor_prescription',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

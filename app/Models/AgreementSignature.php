<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgreementSignature extends Model
{
    protected $fillable = [
        'agreement_id',
        'user_id',
        'signature',
        'signed_at',
        'ip_address',
        'sign_lat',
        'sign_long',
    ];

    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

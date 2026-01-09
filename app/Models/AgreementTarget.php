<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgreementTarget extends Model
{
    protected $fillable = [
        'agreement_id',
        'target_id',
        'commission_on',
        'commission_type',
        'commission',
    ];

    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'target_id', 'id'); 
    }
}

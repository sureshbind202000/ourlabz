<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    protected $fillable = [
        'title',
        'description',
        'agreement_type',
        'target_type',
        'status',
        'created_by',
        'updated_by',
        'activated_at',
    ];

    protected $casts = [
        'activated_at' => 'datetime',
    ];

    public function targets()
    {
        return $this->hasMany(AgreementTarget::class);
    }

    public function signatures()
    {
        return $this->hasMany(AgreementSignature::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

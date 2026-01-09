<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'card_no',
        'exp_month',
        'exp_year',
        'cvv',
    ];
}

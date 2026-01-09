<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAbha extends Model
{
    use HasFactory;

    protected $table = 'user_abhas';

    protected $fillable = [
        'user_id',
        'abha_number',
        'abha_address',
        'health_id_number',
        'status'
    ];
}

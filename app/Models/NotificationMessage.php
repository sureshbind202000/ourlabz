<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationMessage extends Model
{
    protected $fillable = [
        'notification_for',
        'slug',
        'message',
        'link',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModulePermission extends Model
{
        protected $fillable = [
            'user_id',
            'module_id',
            'can_view',
            'can_create',
            'can_edit',
            'can_delete',
        ];

        public function module()
        {
            return $this->belongsTo(Module::class);
        }

        public function user()
        {
            return $this->belongsTo(User::class);
        }
}

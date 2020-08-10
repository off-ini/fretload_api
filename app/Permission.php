<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    protected $fillable = [
        'tag',
        ];

    public function role_users()
    {
        return $this->belongsToMany('App\RoleUser', 'permission_role_user', 'role_user_id', 'permission_id')
                    ->withTimestamps();
    }
}

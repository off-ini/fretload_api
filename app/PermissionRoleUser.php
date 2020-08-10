<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRoleUser extends Model
{
    //
    protected $table = 'permission_role_user';
    protected $fillable = [
        'role_user_id',
        'permission_id',
    ];
}

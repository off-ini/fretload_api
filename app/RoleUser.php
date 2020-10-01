<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    //
    protected $table = 'role_user';

    protected $fillable = [
        'role_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function role()
    {
        return $this->belongsTo('App\Role', 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'permission_role_user', 'role_user_id', 'permission_id')
                    ->withTimestamps();
    }
}

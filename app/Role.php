<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = [
        'libelle',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany('App\User', 'role_user', 'user_id', 'role_id')
                    ->withTimestamps();
    }

    public function role_users()
    {
        return $this->hasMany('App\RoleUser', 'role_id');
    }
}

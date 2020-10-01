<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded  = [
        'id'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User', 'notification_user', 'nofication_id', 'user_id')
                    ->withPivot('is_read')
                    ->withTimestamps();
    }
}

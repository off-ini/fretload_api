<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposition extends Model
{
    protected $guarded  = [
        'id'
    ];

    public function missions()
    {
        return $this->hasMany('App\Mission', 'proposition_id');
    }
}

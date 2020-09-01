<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposition extends Model
{
    public static $status = [
        'TRAITEMENT',
        'VALIDER'
    ];

    protected $guarded  = [
        'id'
    ];

    public function missions()
    {
        return $this->hasMany('App\Mission', 'proposition_id');
    }

    public function annonce()
    {
        return $this->belongsTo('App\Annonce', 'annonce_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}

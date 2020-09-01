<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destinataire extends Model
{
    protected $guarded  = [
        'id'
    ];

    public function ville()
    {
        return $this->belongsTo('App\Ville', 'ville_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function marchandises()
    {
        return $this->hasMany('App\Marchandise', 'destinataire_id');
    }

    public function missions()
    {
        return $this->hasMany('App\Mission', 'destinataire_id');
    }
}

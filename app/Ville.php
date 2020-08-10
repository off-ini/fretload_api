<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    protected $guarded  = [
        'id'
    ];

    public function pays()
    {
        return $this->belongsTo('App\Pays', 'pays_id');
    }

    public function users()
    {
        return $this->hasMany('App\User', 'ville_id');
    }

    public function destinataire()
    {
        return $this->hasMany('App\Destinataire', 'ville_id');
    }

    public function lieux()
    {
        return $this->hasMany('App\Lieu', 'ville_id');
    }
}

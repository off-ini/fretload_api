<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class adresse extends Model
{
    protected $table='adresses';
    protected $guarded  = [
        'id'
    ];

    public function ville()
    {
        return $this->belongsTo('App\Ville', 'ville_id');
    }

    public function adresse_departs()
    {
        return $this->hasMany('App\Marchandise', 'adresse_depart_id');
    }

    public function adresse_arrivers()
    {
        return $this->hasMany('App\Marchadise', 'adresse_arriver_id');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lieu extends Model
{
    protected $table='lieux';
    protected $guarded  = [
        'id'
    ];

    public function ville()
    {
        return $this->belongsTo('App\Ville', 'ville_id');
    }

    public function lieu_departs()
    {
        return $this->hasMany('App\Marchandise', 'lieu_depart_id');
    }

    public function lieu_arrivers()
    {
        return $this->hasMany('App\Marchadise', 'lieu_arriver_id');
    }

}

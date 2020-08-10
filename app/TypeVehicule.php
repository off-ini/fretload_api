<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeVehicule extends Model
{
    protected $guarded  = [
        'id'
    ];

    public function vehicules()
    {
        return $this->hasMany('App\Vehicule', 'type_vehicule_id');
    }
}

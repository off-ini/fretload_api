<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    public static $status = [
        'LIBRE',
        'LIVRAISON'
    ];

    protected $guarded  = [
        'id'
    ];

    public function type_vehicule()
    {
        return $this->belongsTo('App\TypeVehicule', 'type_vehicule_id');
    }

    public function missions()
    {
        return $this->belongsToMany('App\Mission', 'mission_vehicule', 'mission_id', 'vehicule_id')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vehicule extends Model
{
    protected $guarded  = [
        'id'
    ];

    public function type_vehicule()
    {
        return $this->belongsTo('App\TypeVehicule', 'type_vehicule_id');
    }

    public function missions()
    {
        return $this->belongsToMany('App\Mission', 'mission_vehicule', 'vehicule_id', 'mission_id')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}

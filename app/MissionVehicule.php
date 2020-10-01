<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionVehicule extends Model
{
    protected $table = 'mission_vehicule';
    protected $guarded  = [
        'id'
    ];
}

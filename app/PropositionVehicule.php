<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropositionVehicule extends Model
{
    protected $table = 'proposition_vehicule';
    protected $guarded  = [
        'id'
    ];
}

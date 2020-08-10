<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChauffeurMission extends Model
{
    protected $table = 'chauffeur_mision';
    protected $guarded  = [
        'id'
    ];
}

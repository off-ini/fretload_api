<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $guarded  = [
        'id'
    ];

    public function marchandise()
    {
        return $this->belongsTo('App\Marchandise', 'marchandise_id');
    }

    public function transpoteur()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function proposition()
    {
        return $this->belongsTo('App\Proposion', 'proposition_id');
    }

    public function chauffeurs()
    {
        return $this->belongsToMany('App\User', 'chauffeur_mission', 'user_id', 'mission_id')
                    ->withTimestamps();
    }

    public function vehicules()
    {
        return $this->belongsToMany('App\Vehicule', 'mission_vehicule', 'vehicule_id', 'mission_id')
                    ->withTimestamps();
    }
}

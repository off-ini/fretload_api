<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    public static $status = [
        'CHARGEMENT',
        'EN COURS',
        'LIVRER',
        'PAYER',
    ];

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

    public function proprietaire()
    {
        return $this->belongsTo('App\User', 'user_p_id');
    }


    public function proposition()
    {
        return $this->belongsTo('App\Proposition', 'proposition_id');
    }

    public function destinataire()
    {
        return $this->belongsTo('App\Destinataire', 'destinataire_id');
    }

    public function chauffeurs()
    {
        return $this->belongsToMany('App\User', 'chauffeur_mission', 'mission_id', 'user_id')
                    ->withTimestamps();
    }

    public function vehicules()
    {
        return $this->belongsToMany('App\Vehicule', 'mission_vehicule', 'mission_id', 'vehicule_id')
                    ->withTimestamps();
    }
}

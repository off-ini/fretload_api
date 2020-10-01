<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marchandise extends Model
{
    public static $status = [
        'LIBRE',
        'ANNONCER',
        'CHARGEMENT',
        'TRANSIT',
        'LIVRER'
    ];

    protected $guarded  = [
        'id'
    ];

    public function type_marchandie()
    {
        return $this->belongsTo('App\TypeMarchandise', 'type_marchandise_id');
    }

    public function adresse_depart()
    {
        return $this->belongsTo('App\Adresse', 'adresse_depart_id');
    }

    public function adresse_arriver()
    {
        return $this->belongsTo('App\Adresse', 'adresse_arriver_id');
    }

    public function destinataire()
    {
        return $this->belongsTo('App\Destinataire', 'destinataire_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function annones()
    {
        return $this->hasMany('App\Annonce', 'marchandise_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    protected $guarded  = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function marchandise()
    {
        return $this->belongsTo('App\Marchandise', 'marchandise_id');
    }

    public function propositions()
    {
        return $this->belongsToMany('App\User', 'propositions', 'annonce_id', 'user_id')
                    ->withPivot('montant', 'accepted_at', 'status')
                    ->withTimestamps();
    }
}

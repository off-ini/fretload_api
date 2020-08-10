<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    protected $table='pays';
    protected $guarded  = [
        'id'
    ];

    public function villes()
    {
        return $this->belongsTo('App\Ville', 'pays_id');
    }
}

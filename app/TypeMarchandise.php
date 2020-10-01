<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeMarchandise extends Model
{
    protected $guarded  = [
        'id'
    ];

    public function marchandises()
    {
        return $this->hasMany('App\Marchandise', 'type_marchandise_id');
    }
}

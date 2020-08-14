<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModePayement extends Model
{
    protected $guarded  = [
        'id'
    ];

    public function payements()
    {
        return $this->hasMany('App\Payement', 'mode_payement_id');
    }
}

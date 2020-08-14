<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payement extends Model
{
    protected $guarded  = [
        'id'
    ];

    public function mode_payement()
    {
        return $this->belongsTo('App\ModePayement', 'mode_payement_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function mission()
    {
        return $this->belongsTo('App\Mission', 'mission_id');
    }
}

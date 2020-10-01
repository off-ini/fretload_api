<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Annonce extends Model
{
    protected $guarded  = [
        'id'
    ];

    public static function getCode()
    {
        $key = Str::upper(Str::random(6));
        if(static::where(['code' => $key])->first())
            return static::getCode();
        return $key;
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function marchandise()
    {
        return $this->belongsTo('App\Marchandise', 'marchandise_id');
    }

    public function ps()
    {
        return $this->hasMany('App\Proposition', 'annonce_id');
    }

    public function propositions()
    {
        return $this->belongsToMany('App\User', 'propositions', 'annonce_id', 'user_id')
                    ->withPivot('montant_t', 'montant_p', 'accepted_at', 'status', 'is_read', 'proposition_reply_id')
                    ->withTimestamps();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Link extends Model
{
    protected $guarded  = [
        'id'
    ];

    public static function getCode()
    {
        $key = Str::upper(Str::random(32));
        if(static::where(['code' => $key])->first())
            return static::getCode();
        return $key;
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}

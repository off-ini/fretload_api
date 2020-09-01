<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];*/

    public static $status = [
        'LIBRE',
        'LIVRAISON'
    ];

    protected $guarded  = [
        'id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'role_users'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function getCode()
    {
        $key = Str::upper(Str::random(8));
        if(static::where(['code' => $key])->first())
            return static::getCode();
        return $key;
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id')
                    ->withTimestamps();
    }

    public function notifications()
    {
        return $this->belongsToMany('App\Notification', 'notification_user', 'nofication_id', 'user_id')
                    ->withPivot('is_read')
                    ->withTimestamps();
    }

    public function propositions()
    {
        return $this->belongsToMany('App\Annonce', 'propositions', 'annonce_id', 'user_id')
        ->withPivot('montant_t', 'montant_p', 'accepted_at', 'status', 'is_read', 'proposition_reply_id')
                    ->withTimestamps();
    }

    public function chauffeur_missions()
    {
        return $this->belongsToMany('App\Mission', 'chauffeur_mission', 'mission_id', 'chauffeur_id')
                    ->withTimestamps();
    }

    public function role_users()
    {
        return $this->hasMany('App\RoleUser', 'user_id');
    }

    public function links()
    {
        return $this->hasMany('App\Link', 'user_id');
    }

    public function adresses()
    {
        return $this->hasMany('App\Adresse', 'user_id');
    }

    public function chauffeures()
    {
        return $this->hasMany('App\User', 'user_chauffeur_id');
    }

    public function destinataires()
    {
        return $this->hasMany('App\Destinataire', 'user_id');
    }

    public function annonces()
    {
        return $this->hasMany('App\Annonce', 'user_id');
    }

    public function missions()
    {
        return $this->hasMany('App\Mission', 'user_id');
    }

    public function proprietaire_missions()
    {
        return $this->hasMany('App\Mission', 'user_p_id');
    }

    public function vehicules()
    {
        return $this->hasMany('App\Vehicule', 'user_id');
    }

    public function marchandises()
    {
        return $this->hasMany('App\Marchandise', 'user_id');
    }

    public function chauffeures_user()
    {
        return $this->belongsTo('App\User', 'user_chauffeur_id');
    }

    public function ville()
    {
        return $this->belongsTo('App\Ville', 'ville_id');
    }
}

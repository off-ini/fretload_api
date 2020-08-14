<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public $preserveKeys = true;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'f_name' => $this->f_name,
            'naissance' => $this->naissance,
            'sexe' => $this->sexe == 'H' ? 'Homme' : 'Femme',
            'email' => $this->email,
            'phone' => $this->phone,
            'adresse' => $this->adresse,
            'photo' => $this->photo,
            'ville' => new VilleResource($this->ville),
            'pays' => new PaysResource($this->ville->pays),
            'roles' => RoleResource::collection($this->roles),
            //'permissions' => PermissionResource::collection($this->role_users->permissions),
            'username' => $this->username,
        ];
    }
}

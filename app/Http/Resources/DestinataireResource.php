<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DestinataireResource extends JsonResource
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
            'created_at' => $this->created_at,
        ];
    }
}

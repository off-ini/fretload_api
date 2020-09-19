<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdresseResource extends JsonResource
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
            'description' => $this->description,
            'adresse' => $this->adresse,
            'logitude' => $this->logitude,
            'latitude' => $this->latitude,
            'ville' => new VilleResource($this->ville),
            'pays' => new PaysResource($this->ville->pays),
            'created_at' => $this->created_at,
        ];
    }
}

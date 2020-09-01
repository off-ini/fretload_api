<?php

namespace App\Http\Resources;

use App\Vehicule;
use Illuminate\Http\Resources\Json\JsonResource;

class VehiculeResource extends JsonResource
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
            'libelle' => $this->libelle,
            'matricule' => $this->matricule,
            'description' => $this->description,
            'capacite' => $this->capacite,
            'taille' => $this->taille,
            'image' => $this->image,
            'status' => $this->status,
            'type' => new TypeVehiculeResource($this->type_vehicule),
        ];
    }
}

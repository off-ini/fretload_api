<?php

namespace App\Http\Resources;

use App\Marchandise;
use Illuminate\Http\Resources\Json\JsonResource;

class MarchandiseResource extends JsonResource
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
        //$status = Marchandise::$status[$this->status];
        return [
            'id' => $this->id,
            'libelle' => $this->libelle,
            'description' => $this->description,
            'image' => $this->image,
            'poid' => $this->poid,
            'volume' => $this->volume,
            'qte' => $this->qte,
            'status' => $this->status,
            'adresse_depart' => new AdresseResource($this->adresse_depart),
            'adresse_arriver' => new AdresseResource($this->adresse_arriver),
            'destinataire' => new DestinataireResource($this->destinataire),
            'type' => new TypeMarchandiseResource($this->type_marchandie),
        ];
    }
}

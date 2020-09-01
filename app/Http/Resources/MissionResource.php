<?php

namespace App\Http\Resources;

use App\Mission;
use Illuminate\Http\Resources\Json\JsonResource;

class MissionResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'montant' => $this->montant,
            'date_depart_pre' => $this->date_depart_pre,
            'date_depart_eff' => $this->date_depart_eff,
            'date_arriver_pre' => $this->date_arriver_pre,
            'date_arriver_eff' => $this->date_arriver_eff,
            'status' => $this->status,
            'marchandise' => new MarchandiseResource($this->marchandise),
            'destinataire' => new DestinataireResource($this->destinataire),
            'proposition' => new PropositionResource($this->proposition),
            'chauffeurs' => UserShowResource::collection($this->chauffeurs),
            'vehicules' => VehiculeResource::collection($this->vehicules),
            'proprietaire' => $this->user_p_id,
        ];
    }
}

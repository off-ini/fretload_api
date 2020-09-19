<?php

namespace App\Http\Resources;

use App\Proposition;
use Illuminate\Http\Resources\Json\JsonResource;

class PropositionResource extends JsonResource
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
            'montant_t' => $this->montant_t,
            'status' => $this->status,
            'is_read' => $this->is_read,
            'is_accept' => $this->is_accept,
            'is_mission' => $this->is_mission,
            'accepted_at' => $this->accepted_at,
            'status' => Proposition::$status[$this->status],
            'annonce' => new AnnonceResource($this->annonce),
            'vehicules' => VehiculeResource::collection($this->vehicules),
            'created_at' => $this->created_at,
        ];
    }
}

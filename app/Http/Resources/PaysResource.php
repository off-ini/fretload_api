<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaysResource extends JsonResource
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
            'value' => $this->id,
            'code' => $this->code,
            'phone_code' => $this->phone_code,
            'label' => $this->name,
            'villes' => VilleResource::collection($this->villes)
        ];
    }
}

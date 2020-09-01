<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnnonceResource extends JsonResource
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
            'body' => $this->body,
            'payload' => $this->payload,
            'is_public' => $this->is_public,
            'marchandise' => new MarchandiseResource($this->marchandise),
            'owner_id' => $this->user_id,
            'owner' => new UserShowResource($this->user),
            'user_sigle' => $this->user_sigle,
        ];
    }
}

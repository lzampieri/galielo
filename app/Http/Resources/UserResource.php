<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
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
            'email' => $this->email,
            'slogan' => $this->slogan,
            'bio' => $this->bio,
            'name' => ( $this->player ? $this->player->name : null),
            'apoints' => ( $this->player ? $this->player->apoints : null),
            'dpoints' => ( $this->player ? $this->player->dpoints : null)
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CcupResource extends JsonResource
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
            'date' => $this->created_at,
            'pl1_id' => $this->pl1_id,
            'pl1' => $this->pl1->name,
            'pl2_id' => $this->pl2_id,
            'pl2' => $this->pl2->name,
            'game1_id' => $this->game1_id,
            'game1' => new GameResource($this->game1),
            'game2_id' => $this->game2_id,
            'game2' => new GameResource($this->game2)
        ];
    }
}

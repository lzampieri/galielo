<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
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
            'inserted_by' => $this->inserted_by,
            'att1_id' => $this->att1_id,
            'att1' => $this->att1->name,
            'dif1_id' => $this->dif1_id,
            'dif1' => $this->dif1->name,
            'att2_id' => $this->att2_id,
            'att2' => $this->att2->name,
            'dif2_id' => $this->dif2_id,
            'dif2' => $this->dif2->name,
            'deltaa1' => $this->deltaa1,
            'deltad1' => $this->deltad1,
            'deltaa2' => $this->deltaa2,
            'deltad2' => $this->deltad2,
            'pt1' => $this->pt1,
            'pt2' => $this->pt2,
            'table' => $this->table->name,
            'hidden' => $this->hidden
        ];
    }
}

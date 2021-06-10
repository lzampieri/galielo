<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $amonthago = (new DateTime())->modify('-1 month')->format('Y-m-d H:i:s');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'apoints' => $this->apoints,
            'dpoints' => $this->dpoints,
            'created_at' => $this->created_at,
            'user' => ($this->user ? new UserResource($this->user) : NULL),
            'asAtt1' => $this->asAtt1->count(),
            'asDif1' => $this->asDif1->count(),
            'asAtt2' => $this->asAtt2->count(),
            'asDif2' => $this->asDif2->count(),
            'asAtt1R' => $this->asAtt1->where('created_at','>',$amonthago)->count(),
            'asDif1R' => $this->asDif1->where('created_at','>',$amonthago)->count(),
            'asAtt2R' => $this->asAtt2->where('created_at','>',$amonthago)->count(),
            'asDif2R' => $this->asDif2->where('created_at','>',$amonthago)->count(),
        ];
    }
}

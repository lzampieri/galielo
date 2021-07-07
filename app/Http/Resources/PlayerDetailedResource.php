<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class PlayerDetailedResource extends JsonResource
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
            'asAtt1' => $this->asAtt1()->count(),
            'asAtt1_friend' => $this->asAtt1()
                               ->select('dif1_id', DB::raw('count(*) as cont'))
                               ->groupBy('dif1_id')->orderBy('cont','DESC')
                               ->with('dif1:id,name')->get(),
            'asDif1' => $this->asDif1()->count(),
            'asDif1_friend' => $this->asDif1()
                               ->select('att1_id', DB::raw('count(*) as cont'))
                               ->groupBy('att1_id')->orderBy('cont','DESC')
                               ->with('att1:id,name')->get(),
            'asAtt2' => $this->asAtt2()->count(),
            'asAtt2_friend' => $this->asAtt2()
                               ->select('dif2_id', DB::raw('count(*) as cont'))
                               ->groupBy('dif2_id')->orderBy('cont','DESC')
                               ->with('dif2:id,name')->get(),
            'asDif2' => $this->asDif2()->count(),
            'asDif2_friend' => $this->asDif2()
                               ->select('att2_id', DB::raw('count(*) as cont'))
                               ->groupBy('att2_id')->orderBy('cont','DESC')
                               ->with('att2:id,name')->get(),
            'asAtt1R' => $this->asAtt1()->where('created_at','>',$amonthago)->count(),
            'asDif1R' => $this->asDif1()->where('created_at','>',$amonthago)->count(),
            'asAtt2R' => $this->asAtt2()->where('created_at','>',$amonthago)->count(),
            'asDif2R' => $this->asDif2()->where('created_at','>',$amonthago)->count(),
        ];
    }
}

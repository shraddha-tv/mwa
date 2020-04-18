<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Location extends JsonResource
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
            'address' => $this->address,
            'gs_division' => $this->gs_division,
            'divisional_secretariat' => $this->divisional_secretariat,
            'district' => $this->district,
            'province' => $this->province,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'state' => $this->state,
        ];
    }
}

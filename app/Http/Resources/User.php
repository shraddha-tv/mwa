<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Location as LocationResource;

class User extends JsonResource
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
            'name' => $this->name,
            'state' => $this->state,
            'email' => $this->email,
            'nic' => $this->nic,
            'type' => $this->type,
            'state_id' => $this->state_id,
            'create' => $this->createBy->name,
            'verify' => $this->verify(),
            'contact' => $this->contacts()->pluck('number'),
            'location' => $this->location(),
        ];
    }

    private function location(){
        return new LocationResource($this->locations->first());
    }

    private function verify(){
        return $this->verified_by ? $this->verifyBy->name : null;
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Goods extends JsonResource
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
            'price' => $this->price,
            'unit_price' => $this->unit_price,
            'available_amount' => $this->available_amount,
        ];
    }
}

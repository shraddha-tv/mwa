<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GoodsProfile extends JsonResource
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
            'name_id' => $this->name_id,
            'name' => $this->goodsName->name_sin,
            'price' => $this->price,
            'unit_price' => $this->unit_price,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'available_amount' => $this->available_amount,
            'state' => $this->state,
            'location' => $this->location(),
        ];
    }

    private function location(){
        return $this->user_id ? $this->farmer->locations->first() : '-';
    }
}

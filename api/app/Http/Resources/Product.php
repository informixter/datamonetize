<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'description' => "",
            'price' => floatval($this->price),
            'saleRate' => $this->sale_percent == 0 ? null : floatval($this->sale_percent),
            'quantity' => 1,
            'quantityType' => null,
            'datamonetizeParams' => null
        ];
    }
}

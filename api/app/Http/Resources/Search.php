<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Search extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $price = 0;
        $price_old = 0;
        $saleRate = 0;
        $products = null;
        if (count($this->products) > 0) {
            $products = new ProductCollection($this->products);
            foreach ($this->products as $pr) {
                $price += $pr->price;
                $price_old += $pr->price_old;
            }
            $saleRate = 100 - ((100 * $price) / $price_old);
        }

        return [
            "id" => $this->id,
            "name" => $this->title,
            "description" => $this->description,
            "price" => $price,
            "saleRate" => $saleRate,
            "products" => $products,
        ];
    }
}

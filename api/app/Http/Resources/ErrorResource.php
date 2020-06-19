<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray([
            'message' => $this->message
        ]);
    }

    public static function error(string $message = "")
    {
        return [
            'message' => $message
        ];
    }
}

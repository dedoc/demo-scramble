<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            /**
             * The name of the place.
             */
            'name' => $this->name,
            /**
             * The price of the place.
             */
            'price' => $this->price,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            /**
             * The place where the booking is made.
             */
            'place_id' => $this->place_id,
            /**
             * The user who made the booking.
             */
            'user_id' => $this->user_id,
            /**
             * The date of the booking.
             */
            'date' => $this->date,
        ];
    }
}

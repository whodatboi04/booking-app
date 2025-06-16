<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reference_no' => $this->reference_no,
            'number_of_persons' => $this->number_of_persons,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'firstname' => $this->user->user_info->firstname ?? '',
            'lastname' => $this->user->user_info->lastname ?? '',
            'room_type' => $this->room_type->name ?? '',
            'room_no' => $this->room->room_no ?? '',
            'room_price' => $this->room_type->price,
            'room_description' => $this->room_type->description ?? '',
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at 
        ];
    }
}

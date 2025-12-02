<?php

namespace App\Http\Resources\v1\Admin;

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
            'firstname' => $this->user->user_info->firstname,
            'lastname' => $this->user->user_info->lastname,
            'room_type' => $this->room_type->name,
            'room_no' => $this->room->room_no ?? '--',
            'discount' => $this->discount->name ?? '--',
            'amount' => $this->total_amount ?? '--',
            'total_amount' => isset($this->discount) ? $this->total_amount * $this->discount->percentage : $this->total_amount,
            'number_of_persons' => $this->number_of_persons,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'status' => $this->status
        ];
    }
}

<?php

namespace App\Http\Resources\v1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'booking_reference_no' => $this->booking->reference_no,
            'room_type' => $this->booking->room_type->name,
            'room_no' => $this->room->room_no ?? '--',
            'payment_method' => $this->payment_method->name,
            'total_amount' => $this->total_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status
        ];
    }
}

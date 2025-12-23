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
        $name = trim($this->firstname . " " . $this->lastname);
        $data = [
            'id' => $this->id,
            'reference_no' => $this->reference_no,
            'name' => $name,
            'room_type' => $this->room_type->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'amount' => $this->total_amount ?? '--',
            'total_amount' => isset($this->discount) ? $this->total_amount * $this->discount->percentage : $this->total_amount,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];

        if ($request->routeIs('admin.booking.show')) {
            $data['room_no'] = $this->room->room_no ?? '--';
            $data['discount'] = $this->discount->name ?? '--';
            $data['number_of_persons'] = $this->number_of_persons;
        }

        return $data;
    }
}

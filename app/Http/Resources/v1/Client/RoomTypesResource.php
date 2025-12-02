<?php

namespace App\Http\Resources\v1\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RoomTypesResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->price,
            'room_capacity' => $this->room_capacity,
            'description' => $this->description,
            'room_image' => config('app.url') .  Storage::url('rooms/' . $this->room_image) ?? ''
        ];
    }
}

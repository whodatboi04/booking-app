<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $data = [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'firstname' => $this->user_info->firstname ?? '',
            'lastname' => $this->user_info->lastname ?? '',
            'created_at' => $this->created_at,
            'roles' => $this->roles->pluck('name'),
            'status' => $this->status
        ];

        if ($request->routeIs('users.show')) {
            $data['phone_number'] = $this->user_info->phone ?? '';
            $data['birthdate'] = $this->user_info->birthdate ?? '';
            $data['profile_picture'] = $this->user_info->profile_picture ?? '';
        }

        return $data;
    }
}

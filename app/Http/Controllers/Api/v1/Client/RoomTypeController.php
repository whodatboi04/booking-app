<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\RoomTypeRequest;
use App\Http\Resources\Api\v1\RoomTypesResource;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomTypeController extends Controller
{
    //
    public function roomTypesIndex(RoomTypeRequest $request)
    {
        $validated = $request->validated($request);

        $perPage = $validated['perPage'] ?? 10;

        $data = RoomType::query()
            ->roomTypesFilter($request)
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);

        $rooms = RoomTypesResource::collection($data);
        foreach ($rooms as $room) {
            $url = Storage::url('rooms/' . $room->room_image);
            $room->room_image = config('app.url') . $url;
        }
        return $this->ok('Success', RoomTypesResource::collection($data));
    }
}

<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\RoomTypeRequest;
use App\Http\Resources\v1\Client\RoomTypesResource;
use App\Models\RoomType;
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

        return $this->ok('Success', RoomTypesResource::collection($data));
    }

    public function show(RoomType $roomType)
    {
        return $this->ok('Success', new RoomTypesResource($roomType));
    }
}

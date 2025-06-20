<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\RoomTypeRequest;
use App\Http\Resources\Api\v1\RoomTypesResource;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    //
    public function roomTypesIndex(RoomTypeRequest $request){

        $data = RoomType::query()
            ->roomTypesFilter($request)
            ->paginate(5);

        return RoomTypesResource::collection($data);
    }
}

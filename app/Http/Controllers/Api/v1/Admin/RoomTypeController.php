<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\v1\RoomTypeRequest;
use App\Http\Resources\Api\v1\RoomTypesResource;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomTypeRequest $request)
    {
        $validated = $request->validated();

        $roomImage = $request->file('room_image');
        $fileRenamed = now()->format('Y-m-d') . '_' . $roomImage->hashName();
        $fileLocation = 'public/rooms';
        $path = $roomImage->storeAs($fileLocation, $fileRenamed);

        if (! $path) {
            return $this->notFound('File Path Not Found');
        }

        $validated['room_image'] = $fileRenamed;

        $data = RoomType::create($validated);

        return $this->ok('Successfully Added', new RoomTypesResource($data));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

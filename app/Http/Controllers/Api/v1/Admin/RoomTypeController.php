<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\v1\RoomTypeRequest;
use App\Http\Resources\v1\Client\RoomTypesResource;
use App\Models\RoomType;
use App\Services\Api\UploadFileService;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{

    public function __construct(private UploadFileService $uploadFile) {}

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
        $fileLocation = 'public/rooms';
        $file = $this->uploadFile->uploadImage($roomImage, $fileLocation);

        $validated['room_image'] =  $file;

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

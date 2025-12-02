<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\v1\ManageBookingRequest;
use App\Http\Resources\v1\Admin\BookingResource;
use App\Models\Booking;
use App\Services\Api\Admin\v1\ManageBookingService;

class ManageBookingController extends Controller
{
    public function __construct(
        protected ManageBookingService $manageBookingService
    ) {}

    public function index()
    {
        return BookingResource::collection(Booking::all());
    }

    //Assign Client Room
    public function assignClientRoom(ManageBookingRequest $request, Booking $book)
    {
        $validated = $request->validated();

        $assignedRoom = $this->manageBookingService->assignRoomService($validated, $book);
        if (! $assignedRoom) {
            return $this->conflict('Room Type does not match.');
        }

        return $this->ok('Assigned Room Successfully', $book);
    }
}

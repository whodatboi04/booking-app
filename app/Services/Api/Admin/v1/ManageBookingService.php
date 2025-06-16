<?php

namespace App\Services\Api\Admin\v1;

use App\Models\Booking;

class ManageBookingService {

    public function assignRoomService($request, $book)
    {
        $roomTypeMatch = $book->where('room_type_id', $request['room_id'])->first();
        if (! $roomTypeMatch) {
            return false;
        }

        $assignRoom = $book->update(['room_id' => $request->validated('room_id')]);
        return $assignRoom;

    }
}
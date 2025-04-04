<?php

namespace App\Services\Api\Admin\v1;

use App\Models\Booking;

class ManageBookingService {

    public function assignRoomService($request, $book){

        $assignRoom = $book->update(['room_id' => $request->validated('room_id')]);
        return $assignRoom;

    }
}
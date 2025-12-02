<?php

namespace App\Services\Api\Admin\v1;

use App\Models\Booking;
use App\Models\Room;

class ManageBookingService
{
    /**
     * Check if the room_id has the same room type that user booked 
     */
    public function assignRoomService($request, $book)
    {
        $room = Room::findOrFail($request['room_id']);

        if ($room->room_type_id !== $book->room_type_id) {
            return false;
        }

        return $book->update(['room_id' => $room->id]);
    }
}

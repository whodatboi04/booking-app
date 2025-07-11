<?php

namespace App\Services\Api\Client\v1;

use App\Models\Booking;
use App\Models\Room;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class BookingService {

    use ApiResponse;

    protected $bookedDates;

    public function __construct()
    {
        $this->bookedDates =  Booking::all();
    }
    
    public function bookAppointmentService($request){
        
        $referenceNo = mt_rand(10000000, 99999999);
        $this->referenceNoExist($referenceNo);

        $isRoomTypeAvailable = $this->checkRoomTypeAvailabilityForDates($request['room_type_id'], $request['start_date'], $request['end_date']);
        if(!$isRoomTypeAvailable){
            return false;
        }

        $book = Booking::create(array_merge(
            $request,
            ['user_id' => Auth::user()->id],
            ['reference_no' => $referenceNo]
        ));

        return $book;
    }

    /**
     * 
     * PRIVATE FUNCTION 
     * 
     */
    private function referenceNoExist($reference_no){
        $reference_no_exist = Booking::where('reference_no', $reference_no)->exists();
        while($reference_no_exist){
            $reference_no = mt_rand(10000000, 99999999);
        }
        return $reference_no;
    }

    private function checkRoomTypeAvailabilityForDates($room_type_id, $start_date, $end_date)
    {
        $room = Room::where('room_type_id', $room_type_id)->first(); 

        $isRoomAvailable = $this->checkRoomAvailabilityForDates($room->id, $start_date, $end_date);
        if ($isRoomAvailable) {
            return true; 
        }

        return false; 
    }

    private function checkRoomAvailabilityForDates($room_id, $start_date, $end_date)
    {
        $conflictingBookings = Booking::where('room_id', $room_id)
            ->where(function($query) use ($start_date, $end_date) {
                $query->whereBetween('start_date', [$start_date, $end_date])
                      ->orWhereBetween('end_date', [$start_date, $end_date])
                      ->orWhere(function($query) use ($start_date, $end_date) {
                          $query->where('start_date', '<=', $start_date)
                                ->where('end_date', '>=', $end_date);
                      });
            })->exists(); 
        return !$conflictingBookings;  
    }
}
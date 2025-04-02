<?php

namespace App\Services\Api\Client\v1;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingService{
    
    public function bookAppointmentService($request){
        $reference_no = mt_rand(10000000, 99999999);
        
        $book = Booking::create(array_merge(
            $request->validated(),
            ['user_id' => Auth::user()->id],
            ['reference_no' => $reference_no]
        ));

        return $book;
    }
}
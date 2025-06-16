<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\BookingRequest;
use App\Http\Resources\Api\v1\BookingResource;
use App\Models\Booking;
use App\Services\Api\Client\v1\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct()
    {
        $this->bookingService = new BookingService;
    }

    public function index()
    {
        return BookingResource::collection(Booking::paginate(10));
    }
    
    //Store Booking Appoinement
    public function storeBookingAppoinement(BookingRequest $request){

        $book = $this->bookingService->bookAppointmentService($request->validated());

        if(!$book){
            return $this->badRequest('Room Type is Fully Booked');
        }
        
        return $this->created('Booked Successfully', $book);
    }
}

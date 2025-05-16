<?php

namespace App\Http\Controllers\Api\Admin\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\v1\ManageBookingRequest;
use App\Models\Booking;
use App\Services\Api\Admin\v1\ManageBookingService;
use Illuminate\Http\Request;

class ManageBookingController extends Controller
{
    public function __construct(
        protected ManageBookingService $manageBookingService
    )
    {}
    
    //Assign Client Room
    public function assignClientRoom(ManageBookingRequest $request, Booking $book){
        
        $assignedRoom = $this->manageBookingService->assignRoomService($request, $book);
        
        return $this->ok('Assigned Room Successfully', $assignedRoom);
    }
}

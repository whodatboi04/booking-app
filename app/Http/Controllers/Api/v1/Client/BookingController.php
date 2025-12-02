<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\BookingRequest;
use App\Http\Resources\v1\Client\BookingResource;
use App\Models\Booking;
use App\Services\Api\Client\v1\BookingService;
use App\Services\Api\UploadFileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function __construct(protected BookingService $bookingService){}

    public function index()
    {
        return BookingResource::collection(Booking::paginate(10));
    }

    //Store Booking Appointment
    public function storeBookingAppointment(BookingRequest $request): JsonResponse
    {
        $validated = $request->validated();
        return $this->bookingService->bookAppointmentService($validated);
    }
}

<?php

namespace App\Services\Api\Client\v1;

use App\Http\Resources\v1\Client\BookingResource;
use App\Models\Booking;
use App\Models\Room;
use App\Services\Api\UploadFileService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BookingService
{
    use ApiResponse;

    public function __construct(private UploadFileService $uploadFile){}

    /**
     * @throws \Throwable
     */
    public function bookAppointmentService($validated): JsonResponse
    {
        $isRoomTypeAvailable = $this->checkRoomTypeAvailabilityForDates(
            $validated['room_type_id'], $validated['start_date'], $validated['end_date']
        );
        if (!$isRoomTypeAvailable) {
            return $this->conflict('Room type is not available for the selected dates');
        }

        $file = null;
        if (isset($validated['discount_id'])) {
            if (is_null($validated['discount_id_picture'])) {
                return $this->conflict('You must upload discount ID');
            }

            $fileRequest = $validated->file('discount_id_picture');
            $fileLocation = 'privateFiles/discountIDs';
            $file = $this->uploadFile->uploadImage($fileRequest, $fileLocation);
        }

        try {
            return DB::transaction(function() use ($validated, $file) {
                $book = Booking::create(array_merge($validated, [
                    'reference_no' => Str::upper(Str::random(8) . now()->format('yHis')),
                    'discount_id_picture' => $file ?? null,
                ]));

                return $this->created('Booked Successfully', new BookingResource($book));
            });
        } catch (\Throwable $th) {
            Log::error('Booking failed: ' . $th->getMessage());
            throw $th;
        }
    }

    /**
     *
     * PRIVATE FUNCTION
     *
     */
    private function checkRoomTypeAvailabilityForDates($room_type_id, $start_date, $end_date): bool
    {
        $room = Room::where('room_type_id', $room_type_id)->first();
        if (! $room) {
            return false;
        }

        $isRoomAvailable = $this->checkRoomAvailabilityForDates($room->id, $start_date, $end_date);
        if (! $isRoomAvailable) {
            return false;
        }

        return true;
    }

    private function checkRoomAvailabilityForDates($room_id, $start_date, $end_date): bool
    {
        $conflictingBookings = Booking::where('room_id', $room_id)
            ->where(function ($query) use ($start_date, $end_date) {
                $query->whereBetween('start_date', [$start_date, $end_date])
                    ->orWhereBetween('end_date', [$start_date, $end_date])
                    ->orWhere(function ($query) use ($start_date, $end_date) {
                        $query->where('start_date', '<=', $start_date)
                            ->where('end_date', '>=', $end_date);
                    });
            })->exists();
        return !$conflictingBookings;
    }
}

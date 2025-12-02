<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\v1\PaymentRequest;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentRequest $request)
    {
        $validated = $request->validated();

        $book = Booking::findOrFail($validated['booking_id']);


        $ref = 'INFY-' . now()->format('yHis') . Str::random(5);

        return DB::transaction(function () use ($validated, $book, $ref) {
            $data = Payment::create(array_merge(
                $validated,
                [
                    'reference_no' => $ref,
                    'total_amount' => $book->room_type->price,
                    'status' => 1
                ]
            ));

            return $this->ok('Success', $data);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

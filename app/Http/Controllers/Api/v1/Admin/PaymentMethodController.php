<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\v1\PaymentMethodRequest;
use App\Http\Resources\v1\Admin\PaymentMethodResource;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PaymentMethodRequest $request)
    {
        $validated = $request->validated();

        $perPage = $validated['perPage'] ?? 10;

        $data = PaymentMethod::query()
            ->paymentMethodFilters($validated)
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);

        return $this->ok('Success', PaymentMethodResource::collection($data));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentMethodRequest $request)
    {
        $validated = $request->validated();

        $data = PaymentMethod::create(array_merge(
            $validated,
            ['status' => 0]
        ));

        return $this->created('Created Successfully', $data);
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

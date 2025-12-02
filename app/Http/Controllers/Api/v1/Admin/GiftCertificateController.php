<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\v1\GiftCertificateRequest;
use App\Http\Resources\v1\GiftCertificateResource;
use App\Models\GiftCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GiftCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GiftCertificateRequest $request)
    {
        $validated = $request->validated();

        $perPage = $validated['perPage'] ?? 10;

        $data = GiftCertificate::query()
            ->giftCertFilter($validated)
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);

        return $this->ok('Success', GiftCertificateResource::collection($data));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GiftCertificateRequest $request)
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($validated) {
            $data = GiftCertificate::create($validated);
            return $this->created('Successfully Created', $data);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(GiftCertificate $certificate)
    {
        return $this->ok('Success', new GiftCertificateResource($certificate));
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

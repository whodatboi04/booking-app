<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\v1\GiftCertificateRequest;
use App\Http\Resources\Api\v1\GiftCertificateResource;
use App\Models\GiftCertificate;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;

class GiftCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return GiftCertificateResource::collection(GiftCertificate::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GiftCertificateRequest $request)
    {
        $validated = $request->validated();

        $giftCert = GiftCertificate::create($validated);

        return $this->created('Successfully Created', $giftCert);
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
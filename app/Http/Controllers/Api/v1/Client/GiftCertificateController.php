<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\GiftCertificateRequest;
use App\Models\GiftCertificate;
use App\Models\User;
use App\Services\Api\ExportPdfService;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiftCertificateController extends Controller
{

    public function __construct(private ExportPdfService $pdfService){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        return  $user->gift_certificate;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GiftCertificateRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        $giftCert = GiftCertificate::findOrFail($validated['gift_certificate_id']);
        if ($giftCert->user()->where('user_id', $user->id)->exists()) {
            return $this->conflict('You already claimed gift certificate');
        }

        do {
            $ref = (string) random_int('10000000', '99999999');
        } while ($giftCert->user()->where('reference_no', $ref)->exists());

        $validated['reference_no'] = $ref;

        $giftCert->user()->attach($user->id, ['reference_no' => $validated['reference_no']]);
        
        return $this->created('Gift Certificate Successfully Claimed', $giftCert);
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

     /** 
     * Download PDF 
     */
    public function exportPdf(GiftCertificate $certificate)
    {
        $user = Auth::user();

        $giftCert = $certificate->user()->where('user_id', $user->id)->first();
        if (! $giftCert) {
            return $this->notFound('Gift Certificate Not Found');
        }

        return $this->pdfService->giftCertificate($certificate, $user);
    }
} 

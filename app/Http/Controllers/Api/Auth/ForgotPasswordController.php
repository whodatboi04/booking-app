<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Mail\ForgotPasswordMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{

    protected $dateNow;

    public function __construct()
    {
        $this->dateNow = Carbon::now('asia/manila');
    }

    //Update or Create Reset Token
    private function updateOrCreateResetToken(string $email, string $hashedToken){

        DB::table('password_reset_tokens')
        ->where('email', $email)
        ->updateOrInsert(
            ['email' => $email],
            [
                'token' => $hashedToken, 
                'created_at' =>  $this->dateNow, 
                'expires_in' => $this->dateNow->copy()->addMinutes(2)
            ]
        );

    }

    //Forgot Password
    public function forgotPassword(ForgotPasswordRequest $request){

        $hashToken = Hash::make(Str::random(60). 'RESET_PASSWORD');

        $this->updateOrCreateResetToken($request->email, $hashToken);

        Mail::to($request->email)->queue(new ForgotPasswordMail($request->email, $hashToken));

        return $this->ok(
                'Reset Link Sent', 
                ['token' => $hashToken]
        );

    }

}

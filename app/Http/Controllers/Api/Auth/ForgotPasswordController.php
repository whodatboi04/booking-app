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
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{

    //Update or Create Reset Token
    private function updateOrCreateResetToken(string $email, string $hashedToken){
        DB::table('password_reset_tokens')
        ->where('email', $email)
        ->updateOrInsert(
            ['email' => $email],
            [
                'token' => $hashedToken, 
                'created_at' =>  time_now(), 
                'expires_in' => time_now()->copy()->addMinutes(2)
            ]
        );

    }

    //Forgot Password
    public function forgotPassword(ForgotPasswordRequest $request){

        $rateLimiterKey = 'send-message' . $request->email;

        if (RateLimiter::tooManyAttempts($rateLimiterKey, 5)) {
            $seconds = RateLimiter::availableIn('send-message' . $request->email);
            return $this->tooManyRequest('Too Many Request. You may try again in ' . $seconds . ' seconds');
        }

        RateLimiter::increment($rateLimiterKey, 60);
        $hashToken = Hash::make(Str::random(60). 'RESET_PASSWORD');

        Mail::to($request->email)->queue(new ForgotPasswordMail($request->email, $hashToken));
        $this->updateOrCreateResetToken($request->email, $hashToken);
        
        return $this->ok(
                'Reset Link Sent', 
                ['token' => $hashToken]
        );

    }

}

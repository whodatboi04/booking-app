<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Mail\ForgotPasswordMail;
use App\Services\Api\RateLimitingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{

    public function __construct(private RateLimitingService $rateLimiting){}

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
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        
        $limiter = $this->rateLimiting->sixtySeconds($request->email, $request->ip(), 3, 120);
        if ($limiter) {
            return $this->tooManyRequest('Too Many Request. You may try again in ' . $limiter . ' seconds');
        }
        
        $hashToken = Hash::make(Str::random(60). 'RESET_PASSWORD');

        Mail::to($request->email)->queue(new ForgotPasswordMail($request->email, $hashToken));
        $this->updateOrCreateResetToken($request->email, $hashToken);
        
        return $this->ok(
                'Reset Link Sent', 
                ['token' => $hashToken]
        );

    }

}

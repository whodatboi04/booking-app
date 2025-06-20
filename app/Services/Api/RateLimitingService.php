<?php

namespace App\Services\Api;

use App\Traits\ApiResponse;
use Illuminate\Support\Facades\RateLimiter;

class RateLimitingService {

    use ApiResponse;

    public function sixtySeconds($request, $ip, $maxAttempts, $numberOfSeconds)
    {
        $rateLimiterKey = 'send-message' . $request . $ip;

        if (RateLimiter::tooManyAttempts($rateLimiterKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($rateLimiterKey);
            return $seconds;
        }

        RateLimiter::increment($rateLimiterKey, $numberOfSeconds);
    }
}

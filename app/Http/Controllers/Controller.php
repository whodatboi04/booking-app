<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

abstract class Controller
{
    use ApiResponse, AuthorizesRequests;

    //Respond With Token
    protected function respondWithToken($token, $msg = 'Login Successfully')
    {
        return $this->ok($msg,
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => 1000000
            ]);
    }
}

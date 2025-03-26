<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    use ApiResponse;

    //Respond With Token
    protected function respondWithToken($token, $msg = 'Login Successfully')
    {
        return $this->ok($msg,
        [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}

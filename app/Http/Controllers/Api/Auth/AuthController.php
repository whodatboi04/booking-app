<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //Login
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    //Get Active User
    public function getUser()
    {
        return response()->json(Auth::user());
    }

    //Logout
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    //Refresh Token
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh(), 'Refresh Token');
    }

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

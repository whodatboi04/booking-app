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
        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            $request->merge([
                'username' => $request->email, 
                'email' => null
            ]);
        }

        $loginField = !empty($request->username) ? 'username' : 'email';

        $credentials = $request->only($loginField, 'password');

        if (! $token = Auth::attempt($credentials)) {
            return $this->unauthorized('Invalid Username or Password');
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
    
}

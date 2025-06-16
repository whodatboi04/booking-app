<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

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

    //Google Login 
    // public function googleLogin(){
    //     $redirectUrl = Socialite::driver('google')
    //         ->stateless()
    //         ->redirect()
    //         ->getTargetUrl();

    //     return $this->ok('Success', $redirectUrl);
    // }

    //Google Authentication 
    // public function googleAuth(){
    //     try{
    //         $googleUser = Socialite::driver('google')->stateless()->user();
    //         $user = $this->updateOrCreateUser($googleUser);
    //         $token = JWTAuth::fromUser($user);
    //         return $this->respondWithToken($token);
    //     }catch(\Throwable $e){
    //         Log::error('Google Auth Failed: ' . $e->getMessage());
    //         return $this->serverError('failed');
    //     }
       
    // }

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

    /**
     * 
     * PRIVATE METHODS 
     * 
     */

     private function updateOrCreateUser($userData){
        $user = User::updateOrCreate([

        ]);
     }  
    
}

<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request){

        $user = User::create($request->validated());
        UserInfo::create(array_merge(
                ['user_id' => $user->id]
            ));

        Auth::login($user);

        $token = Auth::attempt($request->only('email', 'password'));

         if (!$token) {
            return $this->serverError('Failed to generate token');
        }

        return $this->respondWithToken($token, 'Registration successful');
    }
}

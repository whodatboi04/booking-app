<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request){
        $validated = $request->validated();

        try {
           return DB::transaction(function () use ($validated) {
               $user = User::create([
                   'username' => $validated['username'],
                   'email' => $validated['email'],
                   'password' => bcrypt($validated['password']),
               ]);

               $user->user_info()->create([
                   'firstname' => $validated['firstname'],
                   'lastname'  => $validated['lastname'],
                   'phone'     => $validated['phone'],
                   'birthdate' => $validated['birthdate'],
               ]);

               $user->roles()->attach(UserRole::USER->value);
               $token = JWTAuth::fromUser($user);
               return $this->respondWithToken($token, 'Registration successful');
           });
        } catch (\Throwable $th) {
            Log::error('Registration Failed: ' . $th->getMessage());
            return $this->serverError('Failed to register');
        }
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    //Check User Ability
    private function hasAbility(string $ability): bool
    {
        $token = JWTAuth::getToken(); 
        $decodedToken = JWTAuth::getPayload($token);

        return in_array($ability, $decodedToken);
    }

    //Ability to Update
    public function update(User $activeUser, User $user){
        dd($activeUser, $user);
    }
}

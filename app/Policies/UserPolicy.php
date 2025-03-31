<?php

namespace App\Policies;

use App\Http\Permission\v1\Abilities;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

    //Check User Ability in Payload
    // private function hasAbility(string $ability): bool
    // {
    //     $token = JWTAuth::getToken(); 
    //     $decodedToken = JWTAuth::getPayload($token);

    //     return in_array($ability, $decodedToken);
    // }

    //Ability to Create
    public function create(User $user){
        return $user->hasPermission('can:create');
    }

    //Ability to Read
    public function read(User $user){
        return $user->hasPermission('can:read');
    }

    //Ability to Update
    public function update(User $user){
        return $user->hasPermission('can:update');
    }

    //Ability to Delete
    public function delete(User $user){
        return $user->hasPermission('can:delete');
    }

    //Ability to Restore
    public function restore(User $user){
        return $user->hasPermission('can:update');
    }

    //Ability to Assign Roles and Permissions
    public function assign(User $user){
        return $user->hasPermission('can:assign');
    }

    //Ability to Accept Payment
    public function accept(User $user){
        return $user->hasPermission('can:accept-payment');
    }

    //Ability to Decline Payment
    public function decline(User $user){
        return $user->hasPermission('can:decline-payment');
    }
}

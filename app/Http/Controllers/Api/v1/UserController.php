<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\UserInfoResource;
use App\Http\Resources\Api\v1\UserResource;
use App\Models\UserInfo;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAllUsers(){
        
        $users = UserInfoResource::collection(UserInfo::all());

        return $this->ok('Users', $users);

    }
}

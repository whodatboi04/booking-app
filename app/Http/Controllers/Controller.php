<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

abstract class Controller
{
    use ApiResponse;
    protected $policyClass;

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

    //Checks parameters with include
    public function include(string $relation) : bool 
    {
        $param = request()->get('include');

        if(!isset($param)){
            return false;
        }

        $includeValues = explode(',', strtolower($param));

        return in_array(strtolower($relation), $includeValues);
    }

    public function isAble($ability, $targetModel){
        return Gate::authorize($ability, [$targetModel, $this->policyClass]);
    }
}

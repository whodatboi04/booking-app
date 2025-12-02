<?php

namespace App\Http\Controllers\Api\v1\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UserInfoRequest;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class UserInfoController extends Controller
{
    public function updateUserInfo(UserInfoRequest $request){

        try {

            $userActiveInfo = UserInfo::where('user_id', Auth::user()->id)->first();
            
            if (! $userActiveInfo) {
                return $this->unauthorized('Invalid User');
            }

            $userInfo = $userActiveInfo->update($request->validated());
    
            return $this->created('User Information Updated', $userInfo);

        }catch(Throwable $th){
            return $this->serverError($th->getMessage());
        }

    }
}

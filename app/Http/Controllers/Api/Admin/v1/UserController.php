<?php

namespace App\Http\Controllers\Api\Admin\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\UserRequest;
use App\Http\Resources\Api\v1\UserInfoResource;
use App\Http\Resources\Api\v1\UserResource;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //Get All Users
    public function getAllUsers(){
        
        $users = UserInfoResource::collection(UserInfo::all());

        return $this->ok('Users', $users);

    }

    //Store User
    public function storeUsers(UserRequest $request){

        $user = User::create(array_merge(
            $request->validated(),
        ));

        UserInfo::create(array_merge(
            ['user_id' => $user->id] 
        ));

        return $this->created('User Created Successfully', $user);

    }

    //Update User
    public function updateUsers(UserRequest $request, User $user){

        $user->update($request->validated());
        return $this->ok('Updated Successfully');

    }

    //Soft Delete Users
    public function deleteUsers(User $user){

        $userInfo = UserInfo::where('user_id', $user->id)->first();
        $user->delete();
        $userInfo->delete();

        return $this->ok('User has been deleted successfully');
    }

    //Get All Deleted Users
    public function getAllDeletedUsers(){
        return UserInfoResource::collection(UserInfo::onlyTrashed()->get());
    }

    //Restore Deleted Users
    public function restoreDeletedUsers(string $user){

        $user = User::onlyTrashed()->find($user);
        if(!$user){
            return $this->notFound('User not found or not deleted');
        }

        $userInfo = UserInfo::onlyTrashed()->where('user_id', $user->id)->first();

        $user->restore();
        $userInfo->restore();

        return $this->ok('User Successfully Restored', $userInfo);
    }

    //Delete Users Permanently
    public function deleteUsersPermanently(string $user){

        $user = User::onlyTrashed()->find($user);
        if(!$user){
            return $this->notFound('User Not Found in Trash');
        }
        
        $user->forceDelete();

        return $this->ok('User Permanently Deleted');
    }
}

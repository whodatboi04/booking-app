<?php

namespace App\Http\Controllers\Api\Admin\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\v1\UserRequest;
use App\Http\Resources\Api\v1\UserInfoResource;
use App\Http\Resources\Api\v1\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Models\UserInfo;

class UserController extends Controller
{

    //Set User Role 
    private function setUserRole(array $roles, $user){
        $rolesArr = [];
        foreach($roles as $role){
            $roles = Role::where('id', $role)->first();
            $rolesArr[] = $roles->id;
        }

        $user->roles()->sync($rolesArr);
        $user->roles;

        return $user;
    }

    //Get All Users
    public function getAllUsers(User $user){
        
        $this->authorize('read', $user);
        $users = UserInfoResource::collection(UserInfo::all());

        return $this->ok('Users', $users);

    }

    //Store User
    public function storeUsers(UserRequest $request, User $user){

        $this->authorize('create', $user);
        $user = $user->create($request->validated());
        UserInfo::create(array_merge(
            ['user_id' => $user->id] 
        ));

        $this->authorize('assign', User::class);
        $this->setUserRole($request->roles, $user);

        return $this->created('User Created Successfully', $user);

    }

    //Show User 
    public function showUser(User $user){
        $this->authorize('read', User::class);
        return new UserResource($user);
    }

    //Update User
    public function updateUsers(UserRequest $request, User $user){

        $this->authorize('update', $user);

        $user->update($request->validated());
        $this->setUserRole($request->roles, $user);
        
        return $this->ok('Updated Successfully');

    }

    //Soft Delete Users
    public function deleteUsers(User $user){
        
            $this->authorize('delete', $user);
            $userInfo = UserInfo::where('user_id', $user->id)->first();
            $user->delete();
            $userInfo->delete();
    
            return $this->ok('User has been deleted successfully');
    }

    //Get All Deleted Users
    public function getAllDeletedUsers(){
        $this->authorize('read', User::class);
        return UserInfoResource::collection(UserInfo::onlyTrashed()->get());
    }

    //Restore Deleted Users
    public function restoreDeletedUsers(User $user){

        $this->authorize('restore', $user);
        $user = $user->onlyTrashed()->find($user);

        if(!$user){
            return $this->notFound('User not found or not deleted');
        }

        $userInfo = UserInfo::onlyTrashed()->where('user_id', $user->id)->first();

        $user->restore();
        $userInfo->restore();

        return $this->ok('User Successfully Restored', $userInfo);
    }

    //Delete Users Permanently
    public function deleteUsersPermanently(User $user){

        $this->authorize('delete', $user);

        $user = $user->onlyTrashed()->find($user);
        if(!$user){
            return $this->notFound('User Not Found in Trash');
        }
        
        $user->forceDelete();

        return $this->ok('User Permanently Deleted');
    }
}

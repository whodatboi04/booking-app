<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\v1\UserRequest;
use App\Http\Resources\v1\UserInfoResource;
use App\Http\Resources\v1\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    //Set User Role
//    private function setUserRole(array $roles, $user)
//    {
//        $rolesArr = [];
//        foreach ($roles as $role) {
//            $roles = Role::where('id', $role)->first();
//            $rolesArr[] = $roles->id;
//        }
//
//        $user->roles()->sync($rolesArr);
//        $user->roles;
//
//        return $user;
//    }

    //Get All Users
    public function getAllUsers(UserRequest $request)
    {
        $user = Auth::user();
        $this->authorize('read', $user);

        $validated = $request->validated();

        $perPage = $validated['perPage'] ?? 10;

        $data = User::query()
            ->userFilter($validated)
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);

        return $this->ok('Users', UserResource::collection($data));
    }

    //Store User
    public function storeUsers(UserRequest $request)
    {
        $user = Auth::user();
        $this->authorize('create', $user);

        $validated = $request->validated();
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
            $this->authorize('assign', $user);
            $user->roles()->sync($validated['roles']);
            return $this->created('User Created Successfully', $user);
        });
    }

    //Show User
    public function showUser(User $user)
    {
        $this->authorize('read', User::class);
        return $this->ok('Success', new UserResource($user));
    }

    //Update User
    public function updateUsers(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update($request->validated());
        $this->setUserRole($request->roles, $user);

        return $this->ok('Updated Successfully');
    }

    //Soft Delete Users
    public function deleteUsers(User $user)
    {

        $this->authorize('delete', $user);
        $userInfo = UserInfo::where('user_id', $user->id)->first();
        $user->delete();
        $userInfo->delete();

        return $this->ok('User has been deleted successfully');
    }

    //Get All Deleted Users
    public function getAllDeletedUsers()
    {
        $this->authorize('read', User::class);
        return UserInfoResource::collection(UserInfo::onlyTrashed()->get());
    }

    //Restore Deleted Users
    public function restoreDeletedUsers(User $user)
    {
        $this->authorize('restore', $user);
        $user = $user->onlyTrashed()->find($user);

        if (!$user) {
            return $this->notFound('User not found or not deleted');
        }

        $userInfo = UserInfo::onlyTrashed()->where('user_id', $user->id)->first();

        $user->restore();
        $userInfo->restore();

        return $this->ok('User Successfully Restored', $userInfo);
    }

    //Delete Users Permanently
    public function deleteUsersPermanently(User $user)
    {

        $this->authorize('delete', $user);

        $user = $user->onlyTrashed()->find($user);
        if (!$user) {
            return $this->notFound('User Not Found in Trash');
        }

        $user->forceDelete();

        return $this->ok('User Permanently Deleted');
    }
}

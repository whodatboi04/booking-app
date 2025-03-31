<?php

namespace App\Http\Controllers\Api\Admin\v1;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionRoleController extends Controller
{
    //Set Permission to Role
    public function setPermissionRole(Request $request, Role $role){
        $permissions = $request->permission;
        $permissionToSync = [];
        foreach($permissions as $key => $value){
            $permission = Permission::where('name', $key)->first();
            if($value){
                $permissionToSync[$key] = $permission->id;
            }
        }

        $role->permissions()->sync($permissionToSync);
        $rolePermission = $role->permissions;

        return $this->ok('Set Permission to Role', $rolePermission);
    }

    //Show Role Permissions
    public function showRolePermissions(Role $role){
        $rolePermissions = $role->permissions;
        $permissionArr = [];
        foreach($rolePermissions as $rolePermission){
            $permissions = Permission::where('id', $rolePermission)->first();
            $permissionArr[] = $permissions;
        }

        return $permissionArr;
    }
}

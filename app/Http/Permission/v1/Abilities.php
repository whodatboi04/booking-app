<?php 

namespace App\Http\Permission\v1;

use App\Models\Permission;
use App\Models\User;

class Abilities {

    private static function getUserPermissions($user, $column){
        $userRoles = $user->roles;
        $permissions = [];

        foreach($userRoles as $userRole){
            $rolePermissions = $userRole->permissions;
            if(!$rolePermissions){
                return response()->json('No Record', 404);
            }
            foreach($rolePermissions as $rolePermission){
                $permissions[] = $rolePermission->$column;
            }
        }

        $permissions = array_unique($permissions);
        return $permissions;
    }

    public static function getPermissions(User $user){
        return SELF::getUserPermissions($user, 'ability');
    }

    public static function getPermissionLabel(User $user){
        return SELF::getUserPermissions($user, 'label');
    }

}
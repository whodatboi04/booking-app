<?php 

namespace App\Http\Permission\v1;

use App\Models\Permission;
use App\Models\User;

class Abilities {

    public static function getAbilities(User $user){
        $userRoles = $user->roles;  
        $permissions = [];

        foreach($userRoles as $userRole){
            $rolePermissions = $userRole->permissions;
            if(!$rolePermissions){
                return response()->json('No Record', 404);
            }
            foreach($rolePermissions as $rolePermission){
                $permissions[] = $rolePermission->ability;
            }
        }

        $permissions = array_unique($permissions);
        return $permissions;
    }

}
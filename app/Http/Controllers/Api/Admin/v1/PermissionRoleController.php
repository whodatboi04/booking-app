<?php

namespace App\Http\Controllers\Api\Admin\v1;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionRoleController extends Controller
{
    public function setPermissionRole(Request $request, Role $role){
        $permissions = $request->permission;
        dd($permissions);

    }
}

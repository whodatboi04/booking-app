<?php

use App\Http\Controllers\Api\Admin\v1\UserController;
use App\Http\Controllers\Api\Admin\v1\PermissionRoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API Version 1

Route::group([
    'middleware' => 'auth:api'
], function () {

    //Users
    Route::group([
        'prefix' => 'users'
    ], function (){
        Route::get('', [UserController::class, 'getAllUsers'])->name('users');
        Route::post('', [UserController::class, 'storeUsers'])->name('users.store');
        Route::put('{user}', [UserController::class, 'updateUsers'])->name('users.update');
        
        //Delete Users
        Route::delete('{user}', [UserController::class, 'deleteUsers'])->name('users.delete');
        Route::get('/deleted', [UserController::class, 'getAllDeletedUsers'])->name('users.delete.index');
        Route::get('{user}/restore', [UserController::class, 'restoreDeletedUsers'])->name('users.restore');
        Route::delete('{user}/delete', [UserController::class, 'deleteUsersPermanently'])->name('users.delete.permanently');

    });

    //Permission 
    Route::group([
        'prefix' => 'permission'
    ], function (){
        Route::post('{role}', [PermissionRoleController::class, 'setPermissionRole'])->name('permission-role.set');
    });

});





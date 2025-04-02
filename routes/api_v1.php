<?php

use App\Http\Controllers\Api\Admin\v1\UserController;
use App\Http\Controllers\Api\Admin\v1\PermissionRoleController;
use App\Http\Controllers\Api\Client\BookingController;
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
        Route::get('/deleted', [UserController::class, 'getAllDeletedUsers'])->name('users.delete.index');
        Route::put('{user}', [UserController::class, 'updateUsers'])->name('users.update');
        Route::get('{user}', [UserController::class, 'showUser'])->name('users.show');
        
        //Delete Users
        Route::delete('{user}', [UserController::class, 'deleteUsers'])->name('users.delete');
        Route::delete('{user}/delete', [UserController::class, 'deleteUsersPermanently'])->name('users.delete.permanently');
        Route::put('{user}/restore', [UserController::class, 'restoreDeletedUsers'])->name('users.restore');

    });

    //Permission 
    Route::group([
        'prefix' => 'permission'
    ], function (){
        Route::post('{role}', [PermissionRoleController::class, 'setPermissionRole'])->name('permission-role.set');
        Route::get('{role}', [PermissionRoleController::class, 'showRolePermissions'])->name('permission-role.show');
        Route::get('', [PermissionRoleController::class, 'authUserPermission'])->name('permission-role.getUser');
    });

    //Booking
    Route::group([
        'prefix' => 'booking'
    ], function (){
        Route::post('', [BookingController::class, 'storeBookingAppoinement'])->name('booking.store');
    });

});





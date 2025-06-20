<?php

use App\Http\Controllers\Api\v1\Admin\ManageBookingController;
use App\Http\Controllers\Api\v1\Admin\GiftCertificateController;
use App\Http\Controllers\Api\v1\Admin\PermissionRoleController;
use App\Http\Controllers\Api\v1\Admin\RoomController;
use App\Http\Controllers\Api\v1\Admin\UserController;
use App\Http\Controllers\Api\v1\Client\BookingController;
use App\Http\Controllers\Api\v1\Client\GiftCertificateController as ClientGiftCertificateController;
use App\Http\Controllers\Api\v1\Client\RoomTypeController;


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
        //Client Booking Route
        Route::post('', [BookingController::class, 'storeBookingAppoinement'])->name('client.booking.store');
        Route::get('', [BookingController::class, 'index'])->name('client.booking.index');
    });

    //Client Gift Certificate
    Route::get('certificate/export-pdf/{certificate}', [ClientGiftCertificateController::class, 'exportPdf'])->name('certificate.export-pdf');
    Route::apiResource('certificate', ClientGiftCertificateController::class);

    //admin
    Route::group([
        'prefix' => 'admin'
    ], function () {
        //Manage booking
        Route::put('/booking/{book}', [ManageBookingController::class, 'assignClientRoom'])->name('admin.booking.assign');

        //Gift Certificate Route
        Route::apiResource('certificate', GiftCertificateController::class)->names('admin.certificate');

        //Room Route
        Route::apiResource('room', RoomController::class)->names('admin');
    });
});

//PUBLIC ROUTE
//Room Types
Route::get('room-types', [RoomTypeController::class, 'roomTypesIndex'])->name('client.room-types.index');    









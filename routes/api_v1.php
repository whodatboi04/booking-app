<?php

use App\Http\Controllers\Api\v1\Admin\ManageBookingController;
use App\Http\Controllers\Api\v1\Admin\GiftCertificateController;
use App\Http\Controllers\Api\v1\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Api\v1\Admin\PaymentMethodController;
use App\Http\Controllers\Api\v1\Admin\PermissionRoleController;
use App\Http\Controllers\Api\v1\Admin\RoleController;
use App\Http\Controllers\Api\v1\Admin\RoomController;
use App\Http\Controllers\Api\v1\Admin\RoomTypeController as AdminRoomTypeController;
use App\Http\Controllers\Api\v1\Admin\UserController;
use App\Http\Controllers\Api\v1\Client\BookingController;
use App\Http\Controllers\Api\v1\Client\GiftCertificateController as ClientGiftCertificateController;
use App\Http\Controllers\Api\v1\Client\PaymentController;
use App\Http\Controllers\Api\v1\Client\RoomTypeController;
use App\Http\Controllers\Api\v1\Admin\UserInfoController;


use Illuminate\Support\Facades\Route;

// API Version 1

Route::group([
    'middleware' => 'auth:api'
], function () {
    // Admin Routes
    Route::group([
        'prefix' => 'admin'
    ], function () {

        // USER INFO
        Route::apiResource('user-info', UserInfoController::class);

        //Manage booking
        Route::prefix('booking')->controller(ManageBookingController::class)->group(function () {
            Route::get('/', 'index')->name('admin.booking.index');
            Route::put('{book}', 'assignClientRoom')->name('admin.booking.assign');
        });


        //Gift Certificate Route
        Route::apiResource('certificate', GiftCertificateController::class)->names('admin.certificate');

        //Room Route
        Route::apiResource('room', RoomController::class)->names('admin');

        //Room Types
        Route::apiResource('room-types', AdminRoomTypeController::class)->names('admin.roomTypes');

        //Payment Methods
        Route::apiResource('payment-method', PaymentMethodController::class);

        //Payment
        Route::apiResource('payment', AdminPaymentController::class)->names('admin.payment');

        //Users
        Route::group([
            'prefix' => 'users'
        ], function () {
            Route::get('', [UserController::class, 'getAllUsers'])->name('users.index');
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
        ], function () {
            Route::post('{role}', [PermissionRoleController::class, 'setPermissionRole'])->name('permission-role.set');
            Route::get('{role}', [PermissionRoleController::class, 'showRolePermissions'])->name('permission-role.show');
            Route::get('', [PermissionRoleController::class, 'authUserPermission'])->name('permission-role.getUser');
        });

        //Client Gift Certificate
        Route::get('certificate/export-pdf/{certificate}', [ClientGiftCertificateController::class, 'exportPdf'])->name('certificate.export-pdf');
        Route::apiResource('certificate', ClientGiftCertificateController::class);

        // Payment
        Route::apiResource('payment', PaymentController::class);

        // Role
        Route::apiResource('roles', RoleController::class);
    });
});

//PUBLIC ROUTE
//Room Types
Route::get('room-types', [RoomTypeController::class, 'roomTypesIndex'])->name('client.room-types.index');
Route::get('room-types/{roomType}', [RoomTypeController::class, 'show'])->name('client.room-types.show');

//Booking
Route::group([
    'prefix' => 'booking'
], function () {
    //Client Booking Route
    Route::post('', [BookingController::class, 'storeBookingAppointment'])->name('client.booking.store');
    Route::get('', [BookingController::class, 'index'])->name('client.booking.index');
});

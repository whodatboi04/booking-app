<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {
    
    //Login and Register
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [RegisterController::class, 'register'])->name('register');

    //Forgot Password
    Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('auth.forgot-password');
    Route::post('reset-password', [ResetPasswordController::class, 'resetPassword'])->name('auth.reset-password');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('refresh', [AuthController::class, 'refresh'])->name('refresh');
        Route::get('getUser', [AuthController::class, 'getUser'])->name('getuser');
    });

});

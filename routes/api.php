<?php


use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Controllers\Api\v1\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\v1\Auth\RegisterController;
use App\Http\Controllers\Api\v1\Auth\ResetPasswordController;
use App\Http\Controllers\Api\v1\Profile\UserInfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Authentication 
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {

    //Login and Register
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [RegisterController::class, 'register'])->name('register');

    //Google Authentication 
    Route::get('google', [AuthController::class, 'googleLogin'])->name('auth.google');
    Route::get('google-callback', [AuthController::class, 'googleAuth'])->name('auth.google-callback');

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

//Profile
Route::put('profile', [UserInfoController::class, 'updateUserInfo'])->middleware('auth:api')->name('profile.store');

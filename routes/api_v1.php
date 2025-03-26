<?php

use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API Version 1

Route::group([
    'middleware' => 'auth:api'
], function () {

    Route::get('users', [UserController::class, 'getAllUsers'])->name('users');

});





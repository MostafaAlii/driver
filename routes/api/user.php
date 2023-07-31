<?php

use App\Http\Controllers\Api\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Auth\User\UserPasswordResetController;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['prefix'=>'user'], function() {
    Route::post('login', [Auth\UserAuthController::class, 'login']);
    Route::post('register', [Auth\UserAuthController::class, 'register']);
    Route::post('logout', [Auth\UserAuthController::class, 'logout']);
    Route::post('verified',[UserController::class, 'verified'])->name('user.verified');
    Route::get('all_users', [UserController::class, 'index'])->name('all_users');

    //Route::post('send-reset-token', [UserPasswordResetController::class, 'sendResetToken'])->name('user-send-reset-token');
    //Route::post('reset-password', [UserPasswordResetController::class, 'resetPassword'])->name('user-resetPassword');
    Route::post('send-otp', [UserController::class, 'sendOtp']);
    Route::post('reset-password', [UserController::class, 'resetPassword']);
    Route::middleware('auth:user-api')->group(function () {


        Route::post('profile_user', [UserController::class, 'show_profile_user'])->name('profile_user');
    });
});

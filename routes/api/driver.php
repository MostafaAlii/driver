<?php

use App\Http\Controllers\Api\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Driver\DriverController;
use App\Http\Controllers\Api\Auth\Driver\DriverPasswordResetController;

/*
|--------------------------------------------------------------------------
| Driver Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['prefix' => 'driver'], function () {
    Route::post('login', [Auth\DriverAuthController::class, 'login']);
    Route::post('register', [Auth\DriverAuthController::class, 'register']);
    Route::post('logout', [Auth\DriverAuthController::class, 'logout']);

    Route::post('verified',[DriverController::class, 'verified'])->name('driver.verified');
    Route::get('all_driver', [DriverController::class, 'index'])->name('all_driver');

    Route::post('send-otp', [DriverController::class, 'sendOtp']);
    Route::post('reset-password', [DriverController::class, 'resetPassword']);
    
    Route::middleware('auth:driver-api')->group(function () {

        Route::post('profile_driver', [DriverController::class, 'show_profile_driver'])->name('profile_driver');
        Route::post('driver_activity',[DriverController::class, 'driver_activity'])->name('driver_activity');

        Route::post('driver_profile_update', [DriverController::class, 'driver_profile_update'])->name('driver_profile_update');
        Route::post('upload-car-images', [DriverController::class, 'uploadCarImages'])->name('uploadCarImages');
        Route::post('upload-personal-images', [DriverController::class, 'uploadPersonalImages'])->name('uploadPersonalImages');
        Route::post('upload_license', [DriverController::class, 'uploadLicense'])->name('upload_license');
        Route::post('check-profile-media', [DriverController::class, 'checkProfileMedia'])->name('checkProfileMedia');
    });

});
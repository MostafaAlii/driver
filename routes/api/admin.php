<?php

use App\Http\Controllers\Api\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['prefix'=>'admin'], function() {
    Route::post('login', [Auth\AdminAuthController::class, 'login']);
    Route::post('logout', [Auth\AdminAuthController::class, 'logout']);
});
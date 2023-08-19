<?php

use App\Models\Settings;
use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\MainSettingResources;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'v1'], function () {
    require_api_routes();

    Route::get('countries', [Api\Setting\CountryController::class, 'index']);
    Route::get('country/{id}', [Api\Setting\CountryController::class, 'show']);

    Route::get('states', [Api\Setting\StateController::class, 'index']);
    Route::get('state/{id}', [Api\Setting\StateController::class, 'show']);

    Route::get('cities', [Api\Setting\CityController::class, 'index']);
    Route::get('city/{id}', [Api\Setting\CityController::class, 'show']);

    // CarMake ::
    Route::get('carMake', [Api\Setting\CarMakeController::class, 'index']);
    Route::get('carMake/{id}', [Api\Setting\CarMakeController::class, 'show']);

    // CarModel ::
    Route::get('carModel', [Api\Setting\CarModelController::class, 'index']);
    Route::get('carModel/{id}', [Api\Setting\CarModelController::class, 'show']);

    // CarType ::
    Route::get('carType', [Api\Setting\CarTypeController::class, 'index']);

    // ServiceLocations ::
    Route::get('serviceLocations', [Api\Setting\ServiceLocationsController::class, 'index']);
    Route::get('serviceLocations/{id}', [Api\Setting\ServiceLocationsController::class, 'show']);

    // timeZones ::
    Route::get('timeZones', [Api\Setting\timeZonesController::class, 'index']);
    Route::get('timeZones/{id}', [Api\Setting\timeZonesController::class, 'show']);

    // timeZones ::
    Route::get('vehicleType', [Api\Setting\vehicleTypeController::class, 'index']);
    Route::get('vehicleType/{id}', [Api\Setting\vehicleTypeController::class, 'show']);

    // timeZones ::
    Route::get('company', [Api\Setting\CompanyController::class, 'index']);
    Route::get('company/{id}', [Api\Setting\CompanyController::class, 'show']);

    // zone ::
    Route::get('zone', [Api\Setting\ZoneController::class, 'index']);
    Route::post('zone', [Api\Setting\ZoneController::class, 'store']);
    Route::post('zone/{id}', [Api\Setting\ZoneController::class, 'update']);
    Route::post('zone/deleted/{id}', [Api\Setting\ZoneController::class, 'deleted']);
    Route::get('zone/{id}', [Api\Setting\ZoneController::class, 'show']);


    // ZoneBound ::
    Route::get('zoneBound', [Api\Setting\ZoneBoundController::class, 'index']);
    Route::post('zoneBound', [Api\Setting\ZoneBoundController::class, 'store']);
    Route::post('zoneBound/{id}', [Api\Setting\ZoneBoundController::class, 'update']);
    Route::post('zoneBound/deleted/{id}', [Api\Setting\ZoneBoundController::class, 'deleted']);
    Route::get('zoneBound/{id}', [Api\Setting\ZoneBoundController::class, 'show']);

    // ZoneType ::
    Route::get('zoneType', [Api\Setting\ZoneTypeController::class, 'index']);
    Route::post('zoneType', [Api\Setting\ZoneTypeController::class, 'store']);
    Route::post('zoneType/{id}', [Api\Setting\ZoneTypeController::class, 'update']);
    Route::post('zoneType/deleted/{id}', [Api\Setting\ZoneTypeController::class, 'deleted']);
    Route::get('zoneType/{id}', [Api\Setting\ZoneTypeController::class, 'show']);

    // Check (User And Drivers) Is Existing
    Route::post('checkExisting',[Api\Setting\SettingController::class, 'checkExisting']);

    /*Route::get('settings', function () {
        $settings = Settings::checkSettings();
        return new MainSettingResources($settings);
    });*/

    Route::get('settings', [Api\Setting\MainSettingController::class, 'index']);

    Route::get('driver_online',[Api\Setting\SettingController::class, 'driver_online']);

    Route::post('driver_closest',[Api\Setting\SettingController::class, 'driver_closest']);
});

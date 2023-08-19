<?php

use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'languageCheck']
    ], function(){
        Route::group(['prefix' => 'dashboard','middleware' => 'auth:admin'], function () {
            Route::get('/dash', [Dashboard\DashboardController::class, 'index'])->name('dashboard');
            // Admins ::
            Route::resource('admins', Dashboard\AdminController::class);
            Route::put('/admins/{admin}/update-status', [Dashboard\AdminController::class, 'updateStatus'])->name('admins.updateStatus');
            Route::delete('admins/destroy/all', [Dashboard\AdminController::class, 'destroy_all'])->name('admins.destroy_all');
        
            // Users ::
            Route::resource('users', Dashboard\UserController::class);
            Route::put('/users/{user}/update-status', [Dashboard\UserController::class, 'updateStatus'])->name('users.updateStatus');
            Route::get('trash/users', [Dashboard\UserController::class, 'users_trashed'])->name('users.trashed');
            Route::put('users/{id}/restore', [Dashboard\UserController::class, 'restore'])->name('users.restore');
            Route::put('users/{id}/force', [Dashboard\UserController::class, 'forceDelete'])->name('users.forceDelete');
            Route::delete('users/destroy/all', [Dashboard\UserController::class, 'delete_all'])->name('users.destroy_all');
        
            // Drivers ::
            Route::resource('drivers', Dashboard\DriverController::class);
            Route::put('/drivers/{driver}/update-status', [Dashboard\DriverController::class, 'updateStatus'])->name('drivers.updateStatus');
            Route::get('trash/drivers', [Dashboard\DriverController::class, 'drivers_trashed'])->name('drivers.trashed');
            Route::put('drivers/{id}/restore', [Dashboard\DriverController::class, 'restore'])->name('drivers.restore');
            Route::put('drivers/{id}/force', [Dashboard\DriverController::class, 'forceDelete'])->name('drivers.forceDelete');
            Route::get('maps/drivers', [Dashboard\DriverController::class, 'getMaps'])->name('drivers.maps');
            Route::put('/drivers/{id}/update-profile', [Dashboard\DriverController::class, 'updateProfile'])->name('drivers.updateProfile');
            Route::put('/drivers/{driver}/updateApprovalTripStatus', [Dashboard\DriverController::class, 'updateApprovalTripStatus'])->name('drivers.updateApprovalTripStatus');
            Route::put('/mediaStatus/{id}', [Dashboard\DriverController::class, 'mediaStatus'])->name('drivers.mediaStatus');
            
            // Countries ::
            Route::resource('countries', Dashboard\CountryController::class);
            Route::post('changeStatusCountry', [Dashboard\CountryController::class, 'changeStatusCountry'])->name('changeStatusCountry');
        
            // States ::
            Route::resource('states', Dashboard\StateController::class);
            Route::post('changeStatusState', [Dashboard\StateController::class, 'changeStatusState'])->name('changeStatusState');
        
            // Cities ::
            Route::resource('cities', Dashboard\CityController::class);
            Route::post('changeStatusCity', [Dashboard\CityController::class, 'changeStatusCity'])->name('changeStatusCity');
        
            // CarMake ::
            Route::resource('carMake', Dashboard\CarMakeController::class);
            Route::post('changeStatusCarMake', [Dashboard\CarMakeController::class, 'changeStatusCarMake'])->name('changeStatusCarMake');
        
            // CarModel ::
            Route::resource('carModel', Dashboard\carModelController::class);
            Route::post('changeStatusCarModel', [Dashboard\carModelController::class, 'changeStatusCarModel'])->name('changeStatusCarModel');

            // CarType ::
            Route::resource('carType', Dashboard\CarTypeController::class);
        
            // settingOtp ::
            Route::resource('settingOtp', Dashboard\SettingOtpController::class);
        
            // ServiceLocations ::
            Route::resource('serviceLocation', Dashboard\ServiceLocationsController::class);
        
            // TimeZones ::
            Route::resource('timeZones', Dashboard\TimeZonesController::class);
        
        
            // vehicleType ::
            Route::resource('vehicleType', Dashboard\VehicleTypesController::class);
        
            // Companies ::
            Route::resource('company', Dashboard\CompanyController::class);
            Route::put('/company/{company}/update-status', [Dashboard\CompanyController::class, 'updateStatus'])->name('company.updateStatus');
            // SOS ::
            Route::resource('sos', Dashboard\SosController::class);
        
            // Zone ::
            Route::resource('zone', Dashboard\ZoneController::class);
        
            // ZoneBound ::
            Route::resource('zoneBound', Dashboard\ZoneBoundController::class);
        
            // ZoneTypes ::
            Route::resource('zoneTypes', Dashboard\ZoneTypesController::class);
        
            // Main Settings ::
            //Route::resource('mainSettings', Dashboard\SettingsController::class);
            Route::controller(Dashboard\SettingsController::class)->prefix('mainSettings')->as('mainSettings.')->group(function() {
                Route::get('/', 'index')->name('index');
                Route::post('update', 'update')->name('update');
            });
            
            Route::controller(Dashboard\LanguageController::class)->prefix('languages')->as('languages.')->group(function() {
                Route::get('/', 'index')->name('index');
                Route::put('{key}', 'update')->name('update');
                Route::get('{key?}', 'checkLanguageDirectory')->name('check');
            });

            Route::get('logs', Dashboard\LogsController::class)->name('logs');
        
        
        });
    });

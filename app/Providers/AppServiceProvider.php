<?php
namespace App\Providers;
use App\Models\Settings;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider {
    public function register(): void {

    }

    public function boot(): void {
        //$settings = Settings::checkSettings();
        //view()->share('setting', $settings);
    }
}
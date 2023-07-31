<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Laravel\Fortify\Contracts\{LoginResponse,LogoutResponse};
use Illuminate\Support\Facades\{Config,RateLimiter};
use App\Actions\Fortify\{CreateNewUser,ResetUserPassword,UpdateUserPassword,UpdateUserProfileInformation};

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $request = request();
        if($request->is('dashboard/*')) {
            Config::set('fortify.guard', 'admin');
            Config::set('fortify.passwords', 'admins');
            Config::set('fortify.prefix', 'dashboard');
            Config::set('fortify.home', 'dashboard');
        } elseif($request->is('driver/*')) {
            Config::set('fortify.guard', 'driver');
            Config::set('fortify.passwords', 'drivers');
            Config::set('fortify.prefix', 'driver');
            Config::set('fortify.home', RouteServiceProvider::HOME);
        } else {
            Config::set('fortify.guard', 'web');
            Config::set('fortify.passwords', 'users');
            Config::set('fortify.prefix', 'user');
            Config::set('fortify.home', RouteServiceProvider::HOME);
        }
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request) {
                if($request->user('admin')) {
                    if($request->user('admin')->status == 'inactive') {
                        auth('admin')->logout();
                        $notification = array(
                                'message' =>  'Your account is inactive. Please contact administrator.',
                                'alert-type' => 'warning'
                        );
                        return redirect('dashboard/login')->with($notification);
                    } else {
                        return redirect()->intended(RouteServiceProvider::ADMIN_DASHBOARD)->with('success', 'Welcome back, '. get_user_data()?->name);
                    }    
                } elseif($request->user('driver')) {
                    if($request->user('driver')->status == 'inactive') {
                        auth('driver')->logout();
                        $notification = array(
                                'message' =>  'Your account is inactive. Please contact administrator.',
                                'alert-type' => 'warning'
                        );
                        return redirect('driver/login')->with($notification);
                    } else {
                        return redirect('/home');
                    }
                }
                else
                    return redirect()->intended('/home');
            }
        });
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request) {
                    if($request->is('dashboard/*'))
                        return redirect('dashboard/login');
                    elseif ($request->is('driver/*'))
                        return redirect('driver/login');
                    else
                        return redirect()->route('login');
                }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(5)->by($email.$request->ip());
        });
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        if(Config::get('fortify.guard') == 'admin')
            Fortify::viewPrefix('auth.admin.');
        else if(Config::get('fortify.guard') == 'driver')
            Fortify::viewPrefix('auth.driver.');
        else
            Fortify::viewPrefix('auth.user.');
    }
}
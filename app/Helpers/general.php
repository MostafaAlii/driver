<?php
use App\{Models\Admin, Enums\Admin\AdminTypes};
use App\Models\CarType;

if (!function_exists('get_user_data')) {
    function get_user_data()
    {
        $guards = ['admin', 'web', 'driver'];
        foreach ($guards as $guard) {
            if (auth($guard)->check())
                return auth($guard)->user();
        }
        return null;
    }
}

if (!function_exists('checkTypeAdmin')) {
    function checkTypeAdmin()
    {
        $data = [
            'user' => get_user_data(),
            'query' => Admin::where('email', '!=', get_user_data()->email)->with(['profile', 'country'])->orderBy('id', 'ASC')
        ];
        if ($data['user']->type !== \App\Enums\Admin\AdminTypes::GENERAL) {
            if ($data['user']->type === 'admin' || $data['user']->type === 'supervisor')
                $data['query']->whereType($data['user']->type)->where('country_id', $data['user']->country_id);
        }
        return $data['query'];
    }
}


if (!function_exists('require_api_routes')) {
    function require_api_routes()
    {
        $files = glob(base_path('routes/api/*.php'));
        foreach ($files as $file) {
            if ($file != base_path('routes/api/api.php'))
                require_once $file;
        }
    }
}

if (!function_exists('getTypeAdmin')) {
    function getTypeAdmin()
    {
        if (auth('admin')->user()->type === \App\Enums\Admin\AdminTypes::GENERAL) {
            $data = AdminTypes::cases();
        } else {
            $data = [\App\Enums\Admin\AdminTypes::ADMIN, \App\Enums\Admin\AdminTypes::SUPERVISOR];
        }
        return $data;
    }
}


/*if (!function_exists('cartype')) {
    $types = CarType::active();
    $years = \Carbon::now()->year;
    if($years > 2010){
        return $types->name == "A";
    }elseif($years > 2015){
        return $types->name == "B";
    }elseif($years > 2020){ 
        return $types->name == "C"; 
    }
}*/

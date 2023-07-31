<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{App, Config, Redirect};
class languageCheck {
    public function handle(Request $request, Closure $next) {
        $locales = Config::get('laravellocalization.supportedLocales');
        $locale = $request->segment(1);
        if (!array_key_exists($locale, $locales))
            return Redirect::to(Config::get('app.url') . '/' . Config::get('app.fallback_locale'));
        
        if ($locales[$locale]['status'] === false || $locales[$locale]['status'] === 0)
            return Redirect::back()->with('error', trans('languages.this_language_is_not_active'));
  
        App::setLocale($locale);
        return $next($request);
    }
}
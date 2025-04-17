<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageMiddleware
{
    public function handle($request, Closure $next)
    {
        // Nếu có 'lang' trên URL thì lưu vào session
        if ($request->has('lang')) {
            $lang = $request->get('lang');
            if (in_array($lang, ['vi', 'en'])) {
                Session::put('locale', $lang);
            }
        }

        // Nếu session có locale thì set cho App
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

        return $next($request);
    }
}

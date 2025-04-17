<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $lang = $request->get('lang', 'vi');  // Lấy ngôn ngữ từ query string (mặc định là 'vi')

        // Kiểm tra nếu ngôn ngữ có hợp lệ thì set ngôn ngữ
        if (in_array($lang, ['vi', 'en'])) {
            App::setLocale($lang);
            Session::put('locale', $lang);  // Lưu ngôn ngữ vào session để giữ lại khi chuyển trang
            Session::put('locale', $lang);  // Lưu ngôn ngữ vào session
            $lang = Session::get('locale', 'vi');  // Mặc định là 'vi' nếu không có
            App::setLocale($lang);

        }

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function attemptLogin(Request $request)
    {
        return Auth::attempt(
            array_merge($this->credentials($request), ['status' => 'active']),
            $request->filled('remember')
        );
    }


    public function authenticated(Request $request, $user)
    {
        if ($user->role === 'admin') {
            return redirect('/admin/post'); // Nếu là admin thì chuyển hướng đến post
        }

        return redirect('/'); // Nếu là user thì chuyển hướng về trang chủ
    }
}

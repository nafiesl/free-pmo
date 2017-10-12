<?php

namespace App\Http\Controllers;

use App\Entities\Users\User;
use App\Http\Requests\Accounts\ChangePasswordRequest;
use App\Http\Requests\Accounts\LoginRequest;
use App\Http\Requests\Accounts\RegisterRequest;
use Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ThrottlesLogins;

    public function __construct(Guard $auth, PasswordBroker $passwords)
    {
        $this->auth = $auth;
        $this->passwords = $passwords;

        $this->middleware('guest', ['only' => ['getLogin', 'postLogin', 'getRegister', 'postRegister']]);
        $this->middleware('auth', ['only' => ['getLogout', 'getProfile', 'patchProfile']]);
    }

    public function getLogin()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($loginData)) {
            flash()->success(trans('auth.welcome', ['name' => Auth::user()->name]));
            return redirect()->intended('home');
        }

        flash()->error(trans('auth.failed'));
        return redirect()->back()->withInput();
    }

    public function getLogout()
    {
        Auth::logout();
        flash()->success('Anda telah logout.');
        return redirect()->route('auth.login');
    }

    public function getRegister()
    {
        return view('auth.register');
    }

    public function postRegister(RegisterRequest $request)
    {
        $registerData = $request->only('name', 'email', 'password');

        $user = User::create($registerData);
        $user->assignRole('customer');
        Auth::login($user);

        flash()->success(trans('auth.welcome', ['name' => $user->name]));
        return redirect()->route('home');
    }
}

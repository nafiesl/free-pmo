<?php

namespace App\Http\Controllers;

use App\Entities\Users\User;
use App\Http\Requests\Accounts\ChangePasswordRequest;
use App\Http\Requests\Accounts\LoginRequest;
use App\Http\Requests\Accounts\RegisterRequest;
use App\Http\Requests\Accounts\UpdateProfileRequest;
use Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AuthController extends Controller
{
    use ResetsPasswords, ThrottlesLogins;

    private $user;

    public function __construct(Guard $auth, PasswordBroker $passwords)
    {
        $this->user = Auth::user();
        $this->auth = $auth;
        $this->passwords = $passwords;

        $this->middleware('guest', ['only' => [
            'getLogin', 'postLogin', 'getRegister', 'postRegister',
            'getActivate'
            ]
        ]);
        $this->middleware('auth', ['only' => [
            'getLogout', 'getChangePassword', 'postChangePassword',
            'getProfile', 'patchProfile'
            ]
        ]);
    }

    public function getLogin()
    {
        return view('auth.login');
    }

    public function postLogin(LoginRequest $request)
    {
        $loginData = $request->only('email', 'password');

        if (Auth::attempt($loginData, $request->has('remember'))) {
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

    public function getActivate($code)
    {
    }

    public function getChangePassword()
    {
        return view('auth.change-password');
    }

    public function postChangePassword(ChangePasswordRequest $request)
    {
        $input = $request->except('_token');

        if (app('hash')->check($input['old_password'], $this->user->password)) {
            $this->user->password = $input['password'];
            $this->user->save();

            flash()->success(trans('auth.password_changed'));
            return redirect()->back();
        }

        flash()->error('Password lama tidak cocok!');
        return redirect()->back();
    }

    public function getProfile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    public function patchProfile(UpdateProfileRequest $request)
    {
        $this->user->name = $request->get('name');
        $this->user->save();

        flash()->success('Profil berhasil diupdate.');
        return redirect()->route('auth.profile');
    }
}

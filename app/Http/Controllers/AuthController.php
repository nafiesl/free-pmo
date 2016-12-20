<?php

namespace App\Http\Controllers;

use App\Entities\Users\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\ChangePasswordRequest;
use App\Http\Requests\Accounts\LoginRequest;
use App\Http\Requests\Accounts\RegisterRequest;
use App\Http\Requests\Accounts\UpdateProfileRequest;
use Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;

class AuthController extends Controller {

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

    public function postLogin(LoginRequest $req)
    {
        $loginData = $req->only('username','password');

        if (Auth::attempt($loginData, $req->has('remember')))
        {
            flash()->success('Selamat datang kembali ' . Auth::user()->name . '.');
            return redirect()->intended('home');
        }

        flash()->error('Mohon maaf, anda tidak dapat login, cek kembali username/password anda!');
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

    public function postRegister(RegisterRequest $req)
    {
        $registerData = $req->only('name','username','email','password');

        $user = User::create($registerData);
        $user->assignRole('customer');
        Auth::login($user);

        flash()->success('Selamat datang ' . $user->name . '.');
        return redirect()->route('home');
    }

    public function getActivate($code)
    {

    }

    public function getChangePassword()
    {
        return view('auth.change-password');
    }

    public function postChangePassword(ChangePasswordRequest $req)
    {
        $input = $req->except('_token');

        if (app('hash')->check($input['old_password'], $this->user->password))
        {
            $this->user->password = $input['password'];
            $this->user->save();

            flash()->success('Password berhasil diubah!');
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

    public function patchProfile(UpdateProfileRequest $req)
    {
        $this->user->name = $req->get('name');
        $this->user->save();

        flash()->success('Profil berhasil diupdate.');
        return redirect()->route('auth.profile');
    }
}

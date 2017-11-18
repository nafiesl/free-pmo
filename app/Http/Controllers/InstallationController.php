<?php

namespace App\Http\Controllers;

use App\Entities\Users\User;
use App\Http\Requests\Accounts\RegisterRequest;
use Auth;

/**
 * Installation Controller
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class InstallationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getRegister()
    {
        if (User::count()) {
            return redirect()->route('auth.login');
        }
        return view('auth.register');
    }

    public function postRegister(RegisterRequest $request)
    {
        $adminData = $request->only('name', 'email', 'password');

        $adminData['api_token'] = str_random(32);

        $admin = User::create($adminData);

        Auth::login($admin);

        $agencyData = collect($request->only('agency_name', 'agency_website', 'email'))
            ->map(function ($value, $key) {
                return [
                    'key'   => $key,
                    'value' => $value,
                ];
            })->toArray();

        \DB::table('site_options')->insert($agencyData);

        flash()->success(trans('auth.welcome', ['name' => $admin->name]));
        return redirect()->route('home');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show user change password form.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('auth.passwords.change');
    }

    /**
     * Update user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $input = $request->validate([
            'old_password'          => 'required',
            'password'              => 'required|between:6,15|confirmed',
            'password_confirmation' => 'required',
        ]);

        if (app('hash')->check($input['old_password'], auth()->user()->password)) {
            $user = auth()->user();
            $user->password = bcrypt($input['password']);
            $user->save();

            flash(trans('auth.password_changed'), 'success');

            return back();
        }

        flash(trans('auth.old_password_failed'), 'danger');

        return back();
    }
}

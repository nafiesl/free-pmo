<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function show()
    {
        return view('users.profile.show');
    }

    public function edit()
    {
        return view('users.profile.edit');
    }

    public function update()
    {
        $user = auth()->user();

        $user->name  = request('name');
        $user->email = request('email');
        $user->save();

        flash(trans('auth.profile_updated'), 'success');

        return back();
    }
}

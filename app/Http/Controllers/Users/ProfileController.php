<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;

/**
 * User Profile Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('users.profile.show', compact('user'));
    }

    public function edit()
    {
        return view('users.profile.edit');
    }

    public function update()
    {
        request()->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:255',
        ]);

        $user = auth()->user();

        $user->name = request('name');
        $user->email = request('email');
        $user->save();

        flash(trans('auth.profile_updated'), 'success');

        return redirect()->route('users.profile.show');
    }
}

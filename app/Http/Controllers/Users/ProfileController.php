<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;

/**
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
        $user = auth()->user();

        $user->name = request('name');
        $user->email = request('email');
        $user->save();

        flash(trans('auth.profile_updated'), 'success');

        return redirect()->route('users.profile.show');
    }
}

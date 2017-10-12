<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        return view('auth.profile', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $profileData = $request->validate([
            'name' => 'required|max:60',
            'email' => 'required|email',
        ]);

        $user = auth()->user();

        $user->name = $profileData['name'];
        $user->email = $profileData['email'];
        $user->save();

        flash()->success(trans('auth.profile_updated'));
        return back();
    }

}

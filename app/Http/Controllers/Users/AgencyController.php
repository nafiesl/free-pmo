<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;

class AgencyController extends Controller
{
    public function show()
    {
        $agency = auth()->user()->agency;
        return view('users.agency.show', compact('agency'));
    }

    public function edit()
    {
        return view('users.agency.edit');
    }

    public function update()
    {
        $agency = auth()->user()->agency;

        $agency->name    = request('name');
        $agency->email   = request('email');
        $agency->website = request('website');
        $agency->address = request('address');
        $agency->phone   = request('phone');
        $agency->save();

        flash(trans('agency.updated'), 'success');

        return redirect()->route('users.agency.show');
    }
}

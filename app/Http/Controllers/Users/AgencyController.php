<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Option;

class AgencyController extends Controller
{
    public function show()
    {
        return view('users.agency.show');
    }

    public function edit()
    {
        return view('users.agency.edit');
    }

    public function update()
    {
        Option::set('agency_name', request('name'));
        Option::set('agency_tagline', request('tagline'));
        Option::set('agency_email', request('email'));
        Option::set('agency_website', request('website'));
        Option::set('agency_address', request('address'));
        Option::set('agency_phone', request('phone'));

        flash(trans('agency.updated'), 'success');

        return redirect()->route('users.agency.show');
    }
}

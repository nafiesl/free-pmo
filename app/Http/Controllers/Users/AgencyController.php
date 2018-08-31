<?php

namespace App\Http\Controllers\Users;

use Option;
use App\Http\Controllers\Controller;

/**
 * Agency Profile Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class AgencyController extends Controller
{
    /**
     * Show agency detail page.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('users.agency.show');
    }

    /**
     * Show agency edit form.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('users.agency.edit');
    }

    /**
     * Process agency detail update.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function update()
    {
        request()->validate([
            'name'    => 'required|string|max:100',
            'tagline' => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'website' => 'required|url|max:255',
            'address' => 'required|string|max:255',
            'city'    => 'required|string|max:100',
            'phone'   => 'required|string|max:255',
        ]);

        Option::set('agency_name', request('name'));
        Option::set('agency_tagline', request('tagline'));
        Option::set('agency_email', request('email'));
        Option::set('agency_website', request('website'));
        Option::set('agency_address', request('address'));
        Option::set('agency_city', request('city'));
        Option::set('agency_phone', request('phone'));

        flash(__('agency.updated'), 'success');

        return redirect()->route('users.agency.show');
    }

    /**
     * Process agency logo upload.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function logoUpload()
    {
        $file = request()->validate([
            'logo' => 'required|file_extension:png|max:100|dimensions:min_width=100,max_width=200',
        ], [
            'file_extension' => 'Silakan upload file format <strong>.png</strong>',
        ]);

        \File::delete(public_path('assets/imgs/'.Option::get('agency_logo_path')));

        $filename = $file['logo']->getClientOriginalName();
        $file['logo']->move(public_path('assets/imgs'), $filename);
        Option::set('agency_logo_path', $filename);
        flash(__('agency.updated'), 'success');

        return redirect()->route('users.agency.show');
    }
}

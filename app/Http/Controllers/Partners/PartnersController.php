<?php

namespace App\Http\Controllers\Partners;

use App\Entities\Partners\Partner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PartnersController extends Controller
{
    /**
     * Display a listing of the partner.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $editablePartner = null;
        $partners        = Partner::where(function ($query) {
            $query->where('name', 'like', '%'.request('q').'%');
        })->paginate(25);

        if (in_array(request('action'), ['edit', 'delete']) && request('id') != null) {
            $editablePartner = Partner::find(request('id'));
        }

        return view('partners.index', compact('partners', 'editablePartner'));
    }

    /**
     * Store a newly created partner in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newPartnerData = $this->validate($request, [
            'name'    => 'required|max:60',
            'email'   => 'nullable|email|unique:partners,email',
            'phone'   => 'nullable|max:255',
            'pic'     => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'notes'   => 'nullable|max:255',
        ]);

        Partner::create($newPartnerData);

        flash(trans('partner.created'), 'success');

        return redirect()->route('partners.index');
    }

    /**
     * Update the specified partner in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Partners\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
    {
        $partnerData = $this->validate($request, [
            'name'      => 'required|max:60',
            'email'     => 'nullable|email|unique:partners,email,'.$partner->id,
            'phone'     => 'nullable|max:255',
            'pic'       => 'nullable|max:255',
            'address'   => 'nullable|max:255',
            'notes'     => 'nullable|max:255',
            'is_active' => 'required|boolean',
        ]);

        $routeParam = request()->only('page', 'q');

        $partner = $partner->update($partnerData);

        flash(trans('partner.updated'), 'success');
        return redirect()->route('partners.index', $routeParam);
    }

    /**
     * Remove the specified partner from storage.
     *
     * @param  \App\Entities\Partners\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        // TODO: user cannot delete partner that has been used in other table
        $this->validate(request(), [
            'partner_id' => 'required',
        ]);

        $routeParam = request()->only('page', 'q');

        if (request('partner_id') == $partner->id && $partner->delete()) {
            flash(trans('partner.deleted'), 'warning');
            return redirect()->route('partners.index', $routeParam);
        }

        flash(trans('partner.undeleted'), 'danger');
        return back();
    }
}

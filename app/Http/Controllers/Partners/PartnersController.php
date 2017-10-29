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

        $partnerTypes = [
            1 => trans('partner.types.customer'),
            2 => trans('partner.types.vendor'),
        ];

        $partners = Partner::where(function ($query) {
            $query->where('name', 'like', '%'.request('q').'%');
        })
            ->withCount('projects')
            ->paginate(25);

        if (in_array(request('action'), ['edit', 'delete']) && request('id') != null) {
            $editablePartner = Partner::find(request('id'));
        }

        return view('partners.index', compact('partners', 'partnerTypes', 'editablePartner'));
    }

    /**
     * Show the create partner form.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $partnerTypes = [
            1 => trans('partner.types.customer'),
            2 => trans('partner.types.vendor'),
        ];

        return view('partners.create', compact('partnerTypes'));
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
            'type_id' => 'required|numeric',
            'email'   => 'nullable|email|unique:partners,email',
            'phone'   => 'nullable|max:255',
            'pic'     => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'notes'   => 'nullable|max:255',
        ]);

        $newPartnerData['owner_id'] = auth()->user()->agency->id;

        Partner::create($newPartnerData);

        flash(trans('partner.created'), 'success');

        return redirect()->route('partners.index');
    }

    /**
     * Show the specified partner.
     *
     * @param  \App\Entities\Partners\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        return view('partners.show', compact('partner'));
    }

    /**
     * Show the edit partner form.
     *
     * @param  \App\Entities\Partners\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        $partnerTypes = [
            1 => trans('partner.types.customer'),
            2 => trans('partner.types.vendor'),
        ];

        return view('partners.edit', compact('partnerTypes', 'partner'));
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
            'type_id'   => 'required|numeric',
            'email'     => 'nullable|email|unique:partners,email,'.$partner->id,
            'phone'     => 'nullable|max:255',
            'pic'       => 'nullable|max:255',
            'address'   => 'nullable|max:255',
            'notes'     => 'nullable|max:255',
            'is_active' => 'required|boolean',
        ]);

        $partner->update($partnerData);

        flash(trans('partner.updated'), 'success');

        return redirect()->route('partners.show', $partner->id);
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

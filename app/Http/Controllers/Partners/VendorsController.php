<?php

namespace App\Http\Controllers\Partners;

use App\Entities\Partners\Vendor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorsController extends Controller
{
    /**
     * Display a listing of the vendor.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $editableVendor = null;
        $vendors        = Vendor::where(function ($query) {
            $query->where('name', 'like', '%'.request('q').'%');
        })->paginate(25);

        if (in_array(request('action'), ['edit', 'delete']) && request('id') != null) {
            $editableVendor = Vendor::find(request('id'));
        }

        return view('vendors.index', compact('vendors', 'editableVendor'));
    }

    /**
     * Store a newly created vendor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newVendorData = $this->validate($request, [
            'name'    => 'required|max:60',
            'notes'   => 'nullable|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        $newVendorData['owner_id'] = auth()->user()->agency->id;

        Vendor::create($newVendorData);

        flash(trans('vendor.created'), 'success');
        return redirect()->route('vendors.index');
    }

    /**
     * Update the specified vendor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Partners\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        $vendorData = $this->validate($request, [
            'name'      => 'required|max:60',
            'notes'     => 'nullable|max:255',
            'website'   => 'nullable|url|max:255',
            'is_active' => 'required|boolean',
        ]);

        $routeParam = request()->only('page', 'q');

        $vendor = $vendor->update($vendorData);

        flash(trans('vendor.updated'), 'success');
        return redirect()->route('vendors.index', $routeParam);
    }

    /**
     * Remove the specified vendor from storage.
     *
     * @param  \App\Entities\Partners\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        $this->validate(request(), [
            'vendor_id' => 'required',
        ]);

        $routeParam = request()->only('page', 'q');

        if (request('vendor_id') == $vendor->id && $vendor->delete()) {
            flash(trans('vendor.deleted'), 'warning');
            return redirect()->route('vendors.index', $routeParam);
        }

        flash(trans('vendor.undeleted'), 'danger');
        return back();
    }
}

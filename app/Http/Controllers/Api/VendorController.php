<?php

namespace App\Http\Controllers\Api;

use App\Entities\Partners\Vendor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::where('is_active', 1)
            ->orderBy('name')
            ->pluck('name', 'id');

        return response()->json($vendors);
    }

    public function list(Request $request)
    {
        $vendorQuery = Vendor::query();

        if ($request->q) {
            $vendorQuery->where('name', 'like', '%'.$request->q.'%');
        }

        return response()->json($vendorQuery->paginate(25), 200);
    }

    public function show(Vendor $vendor)
    {
        $this->authorize('view', $vendor);

        return $vendor;
    }

    public function update(Request $request, Vendor $vendor)
    {
        $this->authorize('update', $vendor);

        $vendor->update($request->validate([
            'name' => 'sometimes|max:60',
            'notes' => 'sometimes|max:255',
            'website' => 'sometimes|url|max:255',
            'is_active' => 'sometimes|boolean',
        ]));

        return response()->json(['message' => __('vendor.updated')], 200);
    }

    public function destroy(Vendor $vendor)
    {
        $this->authorize('delete', $vendor);

        $vendor->delete();

        return response()->json(['message' => __('vendor.deleted')], 200);
    }
}

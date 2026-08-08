<?php

namespace App\Http\Controllers\Api;

use App\Entities\Partners\Customer;
use App\Entities\Partners\Vendor;
use App\Http\Controllers\Controller;

class ReferencesController extends Controller
{
    public function customers()
    {
        $customers = Customer::where('is_active', 1)
            ->orderBy('name')
            ->pluck('name', 'id');

        return response()->json($customers);
    }

    public function vendors()
    {
        $vendors = Vendor::where('is_active', 1)
            ->orderBy('name')
            ->pluck('name', 'id');

        return response()->json($vendors);
    }
}

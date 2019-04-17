<?php

namespace App\Http\Controllers\Api;

use App\Entities\Partners\Vendor;
use App\Http\Controllers\Controller;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::where('is_active', 1)
            ->orderBy('name')
            ->pluck('name', 'id');

        return response()->json($vendors);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Entities\Partners\Customer;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::where('is_active', 1)
            ->orderBy('name')
            ->pluck('name', 'id');

        return response()->json($customers);
    }
}

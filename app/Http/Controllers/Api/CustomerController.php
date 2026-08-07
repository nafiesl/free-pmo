<?php

namespace App\Http\Controllers\Api;

use App\Entities\Partners\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::where('is_active', 1)
            ->orderBy('name')
            ->pluck('name', 'id');

        return response()->json($customers);
    }

    public function list(Request $request)
    {
        $customerQuery = Customer::query();

        if ($request->q) {
            $customerQuery->where('name', 'like', '%'.$request->q.'%');
        }

        return response()->json($customerQuery->paginate(25), 200);
    }

    public function show(Customer $customer)
    {
        $this->authorize('view', $customer);

        return $customer->load('projects');
    }

    public function update(Request $request, Customer $customer)
    {
        $this->authorize('update', $customer);

        $customer->update($request->validate([
            'name' => 'sometimes|max:255',
            'email' => 'sometimes|email|max:255',
            'phone' => 'sometimes|max:255',
            'pic' => 'sometimes|max:255',
            'address' => 'sometimes|max:255',
            'website' => 'sometimes|url|max:255',
            'notes' => 'sometimes|max:255',
            'is_active' => 'sometimes|boolean',
        ]));

        return response()->json(['message' => __('customer.updated')], 200);
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $customer->delete();

        return response()->json(['message' => __('customer.deleted')], 200);
    }
}

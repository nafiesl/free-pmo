<?php

namespace App\Http\Controllers\Api;

use App\Entities\Partners\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customerQuery = Customer::query();

        if ($request->q) {
            $customerQuery->where('name', 'like', '%'.$request->q.'%');
        }
        if ($request->has('is_active')) {
            $customerQuery->where('is_active', $request->is_active);
        }

        return response()->json($customerQuery->paginate(25), 200);
    }

    public function show(Customer $customer)
    {
        $this->authorize('view', $customer);

        return $customer->load('projects');
    }

    public function store(Request $request)
    {
        $this->authorize('create', new Customer);

        $customer = Customer::create($request->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|max:255',
            'pic' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'website' => 'nullable|url|max:255',
            'notes' => 'nullable|max:255',
        ]));

        return response()->json(['message' => __('customer.created'), 'id' => $customer->id], 201);
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

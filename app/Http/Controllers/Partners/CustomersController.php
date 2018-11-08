<?php

namespace App\Http\Controllers\Partners;

use Illuminate\Http\Request;
use App\Entities\Partners\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Partners\CustomerCreateRequest;

class CustomersController extends Controller
{
    /**
     * Display a listing of the customer.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $customers = Customer::where(function ($query) {
            $query->where('name', 'like', '%'.request('q').'%');
        })
            ->latest()
            ->withCount('projects')
            ->paginate(25);

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the create customer form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created customer in storage.
     *
     * @param  \App\Http\Requests\Partners\CustomerCreateRequest  $customerCreateForm
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CustomerCreateRequest $customerCreateForm)
    {
        Customer::create($customerCreateForm->validated());
        flash(__('customer.created'), 'success');

        return redirect()->route('customers.index');
    }

    /**
     * Show the specified customer.
     *
     * @param  \App\Entities\Partners\Customer  $customer
     * @return \Illuminate\View\View
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the edit customer form.
     *
     * @param  \App\Entities\Partners\Customer  $customer
     * @return \Illuminate\View\View
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Partners\Customer  $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Customer $customer)
    {
        $customerData = $this->validate($request, [
            'name'      => 'required|max:60',
            'email'     => 'nullable|email|unique:customers,email,'.$customer->id,
            'phone'     => 'nullable|max:255',
            'pic'       => 'nullable|max:255',
            'address'   => 'nullable|max:255',
            'website'   => 'nullable|url|max:255',
            'notes'     => 'nullable|max:255',
            'is_active' => 'required|boolean',
        ]);

        $customer->update($customerData);

        flash(__('customer.updated'), 'success');

        return redirect()->route('customers.show', $customer->id);
    }

    /**
     * Remove the specified customer from storage.
     *
     * @param  \App\Entities\Partners\Customer  $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Customer $customer)
    {
        // TODO: user cannot delete customer that has been used in other table
        request()->validate([
            'customer_id' => 'required',
        ]);

        $routeParam = request()->only('page', 'q');

        if (request('customer_id') == $customer->id && $customer->delete()) {
            flash(__('customer.deleted'), 'warning');

            return redirect()->route('customers.index', $routeParam);
        }

        flash(__('customer.undeleted'), 'danger');

        return back();
    }
}

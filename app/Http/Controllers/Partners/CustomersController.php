<?php

namespace App\Http\Controllers\Partners;

use App\Entities\Partners\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Partners\CustomerCreateRequest;
use App\Http\Requests\Partners\CustomerUpdateRequest;

class CustomersController extends Controller
{
    /**
     * Display a listing of the customer.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $customerQuery = Customer::latest()->withCount('projects');
        $customerQuery->where('name', 'like', '%'.request('q').'%');
        $customers = $customerQuery->paginate(25);

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
     * @param  \App\Http\Requests\Partners\CustomerUpdateRequest  $customerUpdateForm
     * @param  \App\Entities\Partners\Customer  $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CustomerUpdateRequest $customerUpdateForm, Customer $customer)
    {
        $customer->update($customerUpdateForm->validated());
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
        request()->validate(['customer_id' => 'required']);

        if (request('customer_id') == $customer->id && $customer->delete()) {
            flash(__('customer.deleted'), 'warning');

            return redirect()->route('customers.index', request(['page', 'q']));
        }
        flash(__('customer.undeleted'), 'danger');

        return back();
    }
}

<?php

namespace App\Http\Controllers\Customers;

use App\Entities\Partners\Customer;
use App\Http\Controllers\Controller;

/**
 * Customer Subscriptions Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class SubscriptionsController extends Controller
{
    public function index(Customer $customer)
    {
        $subscriptions = $customer->subscriptions()->orderBy('due_date')->get();

        return view('customers.subscriptions', compact('customer', 'subscriptions'));
    }
}

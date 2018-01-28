<?php

namespace App\Http\Controllers\Customers;

use App\Entities\Partners\Customer;
use App\Http\Controllers\Controller;

/**
 * Customer Payments Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class PaymentsController extends Controller
{
    public function index(Customer $customer)
    {
        $payments = $customer->payments()
            ->latest()
            ->with('project')
            ->paginate();

        return view('customers.payments', compact('customer', 'payments'));
    }
}

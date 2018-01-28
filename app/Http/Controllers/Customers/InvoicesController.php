<?php

namespace App\Http\Controllers\Customers;

use App\Entities\Partners\Customer;
use App\Http\Controllers\Controller;

/**
 * Customer Invoices Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class InvoicesController extends Controller
{
    public function index(Customer $customer)
    {
        $invoices = $customer->invoices()->orderBy('due_date')->get();

        return view('customers.invoices', compact('customer', 'invoices'));
    }
}

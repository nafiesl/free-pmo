<?php

namespace App\Http\Controllers\Customers;

use App\Entities\Partners\Customer;
use App\Http\Controllers\Controller;

/**
 * Customer Projects Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class ProjectsController extends Controller
{
    public function index(Customer $customer)
    {
        $projects = $customer->projects;

        return view('customers.projects', compact('customer', 'projects'));
    }
}

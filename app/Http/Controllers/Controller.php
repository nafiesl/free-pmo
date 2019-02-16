<?php

namespace App\Http\Controllers;

use App\Entities\Partners\Vendor;
use App\Entities\Projects\Project;
use App\Entities\Partners\Customer;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Get collection of projects.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getProjectsList()
    {
        return Project::orderBy('name')->pluck('name', 'id');
    }

    /**
     * Get collection of vendors.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getVendorsList()
    {
        return Vendor::where('is_active', 1)
            ->orderBy('name')
            ->pluck('name', 'id');
    }

    /**
     * Get list of customers and vendors.
     *
     * @return array
     */
    public function getCustomersAndVendorsList()
    {
        return [
            __('customer.customer') => Customer::orderBy('name')->pluck('name', 'id')->all(),
            __('vendor.vendor')     => Vendor::orderBy('name')->pluck('name', 'id')->all(),
        ];
    }
}

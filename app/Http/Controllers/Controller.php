<?php

namespace App\Http\Controllers;

use App\Entities\Partners\Customer;
use App\Entities\Partners\Vendor;
use App\Entities\Projects\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

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
            __('vendor.vendor') => Vendor::orderBy('name')->pluck('name', 'id')->all(),
        ];
    }

    /**
     * Resolve the number of items per page from the "per_page" query string.
     *
     * Defaults to 25, and is capped at 300 to prevent oversized responses.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    public function perPage(Request $request)
    {
        $perPage = (int) $request->get('per_page', 25);

        if ($perPage < 1) {
            $perPage = 25;
        }

        return min($perPage, 300);
    }
}

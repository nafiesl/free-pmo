<?php

namespace App\Entities;

use App\Entities\Users\User;
use App\Entities\Projects\Job;
use App\Entities\Partners\Vendor;
use App\Entities\Projects\Project;
use App\Entities\Partners\Customer;

/**
 * Base Repository Class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
abstract class BaseRepository extends EloquentRepository
{
    /**
     * Get collection of customers.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCustomersList()
    {
        return Customer::orderBy('name')->pluck('name', 'id');
    }

    /**
     * Get list of customers and vendors.
     *
     * @return array
     */
    public function getCustomersAndVendorsList()
    {
        $partners = [
            'Customer' => Customer::orderBy('name')->pluck('name', 'id')->all(),
            'Vendor'   => Vendor::orderBy('name')->pluck('name', 'id')->all(),
        ];

        return $partners;
    }

    /**
     * Get collection of workers.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getWorkersList()
    {
        return User::orderBy('name')->pluck('name', 'id');
    }

    /**
     * Get collection of vendors.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getVendorsList()
    {
        return Vendor::orderBy('name')->pluck('name', 'id');
    }

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
     * Get Job by it's id.
     *
     * @param  int  $jobId
     * @return \App\Entities\Projects\Job
     */
    public function requireJobById($jobId)
    {
        return Job::findOrFail($jobId);
    }
}

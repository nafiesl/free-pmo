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
    public function getCustomersList()
    {
        return Customer::orderBy('name')->pluck('name', 'id');
    }

    public function getCustomersAndVendorsList()
    {
        $partners = [
            'Customer' => Customer::orderBy('name')->pluck('name', 'id')->all(),
            'Vendor'   => Vendor::orderBy('name')->pluck('name', 'id')->all(),
        ];

        return $partners;
    }

    public function getWorkersList()
    {
        return User::orderBy('name')->pluck('name', 'id');
    }

    public function getVendorsList()
    {
        return Vendor::orderBy('name')->pluck('name', 'id');
    }

    public function getProjectsList()
    {
        return Project::orderBy('name')->pluck('name', 'id');
    }

    public function requireJobById($jobId)
    {
        return Job::findOrFail($jobId);
    }
}

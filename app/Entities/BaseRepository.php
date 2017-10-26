<?php

namespace App\Entities;

use App\Entities\Partners\Customer;
use App\Entities\Partners\Vendor;
use App\Entities\Projects\Feature;
use App\Entities\Projects\Project;
use App\Entities\Users\User;

/**
 * Base Repository Class
 */
abstract class BaseRepository extends EloquentRepository
{

    public function getCustomersList()
    {
        return Customer::orderBy('name')->pluck('name', 'id');
    }

    public function getCustomersAndVendorsList()
    {
        return User::orderBy('name')->hasRoles(['customer', 'vendor'])->pluck('name', 'id');
    }

    public function getWorkersList()
    {
        return User::orderBy('name')->hasRoles(['worker'])->pluck('name', 'id');
    }

    public function getVendorsList()
    {
        return Vendor::orderBy('name')->pluck('name', 'id');
    }

    public function getProjectsList()
    {
        return Project::orderBy('name')->pluck('name', 'id');
    }

    public function requireFeatureById($featureId)
    {
        return Feature::findOrFail($featureId);
    }
}

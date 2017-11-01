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
        return Customer::orderBy('name')->pluck('name', 'id');
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

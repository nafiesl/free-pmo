<?php

namespace App\Entities;

use App\Entities\Partners\Customer;
use App\Entities\Projects\Job;
use App\Entities\Users\User;

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
        return Customer::where('is_active', 1)
            ->orderBy('name')
            ->pluck('name', 'id');
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

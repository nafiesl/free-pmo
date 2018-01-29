<?php

namespace App\Policies\Projects;

use App\Entities\Projects\Job;
use App\Entities\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Job model policy class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the job.
     *
     * @param \App\Entities\Users\User   $user
     * @param \App\Entities\Projects\Job $job
     *
     * @return mixed
     */
    public function view(User $user, Job $job)
    {
        // User can only view the job if he is the job's agency owner.
        return true;
    }

    /**
     * Determine whether the user can create jobs.
     *
     * @param \App\Entities\Users\User   $user
     * @param \App\Entities\Projects\Job $job
     *
     * @return mixed
     */
    public function create(User $user, Job $job)
    {
        // User can create a job if they owns an agency.
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the job.
     *
     * @param \App\Entities\Users\User   $user
     * @param \App\Entities\Projects\Job $job
     *
     * @return mixed
     */
    public function update(User $user, Job $job)
    {
        return $user->hasRole('admin')
            || ($user->hasRole('worker') && $job->worker_id == $user->id);
    }

    /**
     * Determine whether the user can delete the job.
     *
     * @param \App\Entities\Users\User   $user
     * @param \App\Entities\Projects\Job $job
     *
     * @return mixed
     */
    public function delete(User $user, Job $job)
    {
        return $user->hasRole('admin');
    }
}

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
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Job  $job
     * @return mixed
     */
    public function view(User $user, Job $job)
    {
        return $user->hasRole('admin')
            || ($user->hasRole('worker') && $job->worker_id == $user->id);
    }

    /**
     * Determine whether the user can create jobs.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Job  $job
     * @return mixed
     */
    public function create(User $user, Job $job)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the job.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Job  $job
     * @return mixed
     */
    public function update(User $user, Job $job)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the job.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Job  $job
     * @return mixed
     */
    public function delete(User $user, Job $job)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can see job pricings.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Job  $job
     * @return mixed
     */
    public function seePricings(User $user, Job $job)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view job comments.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Job  $job
     * @return bool
     */
    public function viewComments(User $user, Job $job)
    {
        // Admin and job workers can commenting on their job.
        return $user->hasRole('admin')
            || ($user->hasRole('worker') && $job->worker_id == $user->id);
    }

    /**
     * Determine whether the user can add comment to a job.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Job  $job
     * @return bool
     */
    public function commentOn(User $user, Job $job)
    {
        // Admin and job workers can commenting on their job.
        return $this->viewComments($user, $job);
    }
}

<?php

namespace App\Policies\Projects;

use App\Entities\Projects\Project;
use App\Entities\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Project model policy class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project.
     *
     * @param \App\Entities\Users\User       $user
     * @param \App\Entities\Projects\Project $project
     *
     * @return mixed
     */
    public function view(User $user, Project $project)
    {
        // User can only view the project if he is the project's agency owner.
        return true;
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param \App\Entities\Users\User       $user
     * @param \App\Entities\Projects\Project $project
     *
     * @return mixed
     */
    public function create(User $user, Project $project)
    {
        // User can create a project if they owns an agency.
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param \App\Entities\Users\User       $user
     * @param \App\Entities\Projects\Project $project
     *
     * @return mixed
     */
    public function update(User $user, Project $project)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param \App\Entities\Users\User       $user
     * @param \App\Entities\Projects\Project $project
     *
     * @return mixed
     */
    public function delete(User $user, Project $project)
    {
        return $user->hasRole('admin');
    }
}

<?php

namespace App\Policies\Projects;

use App\Entities\Projects\Project;
use App\Entities\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Project  $project
     * @return mixed
     */
    public function view(User $user, Project $project)
    {
        // User can only view the project if he is the project's agency owner.
        return $user->agency->id == $project->owner_id;
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Project  $project
     * @return mixed
     */
    public function create(User $user, Project $project)
    {
        // User can create a project if they owns an agency.
        return  ! is_null($user->agency);
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Project  $project
     * @return mixed
     */
    public function update(User $user, Project $project)
    {
        return $this->view($user, $project);
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Project  $project
     * @return mixed
     */
    public function delete(User $user, Project $project)
    {
        return $this->view($user, $project);
    }
}

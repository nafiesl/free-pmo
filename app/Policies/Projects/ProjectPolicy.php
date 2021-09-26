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
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Project  $project
     * @return mixed
     */
    public function view(User $user, Project $project)
    {
        return $user->hasRole('admin')
            || ($user->hasRole('worker') && $user->projects->contains($project->id));
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
        return $user->hasRole('admin');
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
        return $user->hasRole('admin');
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
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view project jobs.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Project  $project
     * @return mixed
     */
    public function viewJobs(User $user, Project $project)
    {
        return $user->hasRole('admin')
            || ($user->hasRole('worker') && $user->projects->contains($project->id));
    }

    /**
     * Determine whether the user can view project payments.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Project  $project
     * @return mixed
     */
    public function viewPayments(User $user, Project $project)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view project subscriptions.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Project  $project
     * @return mixed
     */
    public function viewSubscriptions(User $user, Project $project)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view project invoices.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Project  $project
     * @return mixed
     */
    public function viewInvoices(User $user, Project $project)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view project files.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Project  $project
     * @return mixed
     */
    public function viewFiles(User $user, Project $project)
    {
        return $user->hasRole('admin')
            || ($user->hasRole('worker') && $user->projects->contains($project->id));
    }

    /**
     * Determine whether the user can see project pricings.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Project  $project
     * @return mixed
     */
    public function seePricings(User $user, Project $project)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view project comments.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Project  $project
     * @return bool
     */
    public function viewComments(User $user, Project $project)
    {
        // Admin and project workers can commenting on their project.
        return $user->hasRole('admin')
            || ($user->hasRole('worker') && $user->projects->contains($project->id));
    }

    /**
     * Determine whether the user can add comment to a project.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Project  $project
     * @return bool
     */
    public function commentOn(User $user, Project $project)
    {
        // Admin and project workers can commenting on their project.
        return $this->viewComments($user, $project);
    }
}

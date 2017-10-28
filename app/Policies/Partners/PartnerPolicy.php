<?php

namespace App\Policies\Partners;

use App\Entities\Partners\Partner;
use App\Entities\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartnerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Partners\Partner  $partner
     * @return mixed
     */
    public function view(User $user, Partner $partner)
    {
        // Update $user authorization to view $partner here.
        return true;
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Partners\Partner  $partner
     * @return mixed
     */
    public function create(User $user, Partner $partner)
    {
        // Update $user authorization to create $partner here.
        return true;
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Partners\Partner  $partner
     * @return mixed
     */
    public function update(User $user, Partner $partner)
    {
        // Update $user authorization to update $partner here.
        return true;
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Partners\Partner  $partner
     * @return mixed
     */
    public function delete(User $user, Partner $partner)
    {
        // Update $user authorization to delete $partner here.
        return true;
    }
}

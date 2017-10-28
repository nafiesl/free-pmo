<?php

namespace App\Policies\Partners;

use App\Entities\Partners\Partner;
use App\Entities\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartnerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the partner.
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
     * Determine whether the user can create partners.
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
     * Determine whether the user can update the partner.
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
     * Determine whether the user can delete the partner.
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

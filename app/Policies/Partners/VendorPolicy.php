<?php

namespace App\Policies\Partners;

use App\Entities\Users\User;
use App\Entities\Partners\Vendor;
use Illuminate\Auth\Access\HandlesAuthorization;

class VendorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Partners\Vendor  $vendor
     * @return mixed
     */
    public function view(User $user, Vendor $vendor)
    {
        // Update $user authorization to view $vendor here.
        return true;
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Partners\Vendor  $vendor
     * @return mixed
     */
    public function create(User $user, Vendor $vendor)
    {
        // Update $user authorization to create $vendor here.
        return true;
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Partners\Vendor  $vendor
     * @return mixed
     */
    public function update(User $user, Vendor $vendor)
    {
        // Update $user authorization to update $vendor here.
        return true;
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Partners\Vendor  $vendor
     * @return mixed
     */
    public function delete(User $user, Vendor $vendor)
    {
        // Update $user authorization to delete $vendor here.
        return true;
    }
}

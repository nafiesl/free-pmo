<?php

namespace App\Policies\Partners;

use App\Entities\Users\User;
use App\Entities\Partners\Customer;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Partners\Customer  $customer
     * @return mixed
     */
    public function view(User $user, Customer $customer)
    {
        // Update $user authorization to view $customer here.
        return true;
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Partners\Customer  $customer
     * @return mixed
     */
    public function create(User $user, Customer $customer)
    {
        // Update $user authorization to create $customer here.
        return true;
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Partners\Customer  $customer
     * @return mixed
     */
    public function update(User $user, Customer $customer)
    {
        // Update $user authorization to update $customer here.
        return true;
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Partners\Customer  $customer
     * @return mixed
     */
    public function delete(User $user, Customer $customer)
    {
        // Update $user authorization to delete $customer here.
        return true;
    }
}

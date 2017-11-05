<?php

namespace App\Policies\Partners;

use App\Entities\Partners\Customer;
use App\Entities\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Customer model policy class
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class CustomerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the customer.
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
     * Determine whether the user can create customers.
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
     * Determine whether the user can update the customer.
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
     * Determine whether the user can delete the customer.
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

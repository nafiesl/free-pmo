<?php

namespace App\Policies;

use App\Entities\Users\User;
use App\Entities\Users\User as Worker;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * User model policy class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Users\User  $user
     * @return mixed
     */
    public function view(User $user, Worker $worker)
    {
        return true;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Users\User  $user
     * @return mixed
     */
    public function create(User $user, Worker $worker)
    {
        return true;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Users\User  $user
     * @return mixed
     */
    public function update(User $user, Worker $worker)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Users\User  $user
     * @return mixed
     */
    public function delete(User $user, Worker $worker)
    {
        return $user->hasRole('admin')
        && $worker->jobs()->count() == 0
        && $worker->payments()->count() == 0;
    }
}

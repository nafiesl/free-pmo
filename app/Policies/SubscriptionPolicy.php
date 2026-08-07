<?php

namespace App\Policies;

use App\Entities\Subscriptions\Subscription;
use App\Entities\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the subscription.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Subscriptions\Subscription  $subscription
     * @return mixed
     */
    public function view(User $user, Subscription $subscription)
    {
        return $user->can('manage_subscriptions');
    }

    /**
     * Determine whether the user can create subscriptions.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Subscriptions\Subscription  $subscription
     * @return mixed
     */
    public function create(User $user, Subscription $subscription)
    {
        return $user->can('manage_subscriptions');
    }

    /**
     * Determine whether the user can update the subscription.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Subscriptions\Subscription  $subscription
     * @return mixed
     */
    public function update(User $user, Subscription $subscription)
    {
        return $user->can('manage_subscriptions');
    }

    /**
     * Determine whether the user can delete the subscription.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Subscriptions\Subscription  $subscription
     * @return mixed
     */
    public function delete(User $user, Subscription $subscription)
    {
        return $user->can('manage_subscriptions');
    }
}

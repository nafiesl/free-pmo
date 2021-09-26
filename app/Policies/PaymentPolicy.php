<?php

namespace App\Policies;

use App\Entities\Payments\Payment;
use App\Entities\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Payment model policy class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class PaymentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the payment.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Partners\Payment  $payment
     * @return mixed
     */
    public function view(User $user, Payment $payment)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create payments.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Partners\Payment  $payment
     * @return mixed
     */
    public function create(User $user, Payment $payment)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the payment.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Partners\Payment  $payment
     * @return mixed
     */
    public function update(User $user, Payment $payment)
    {
        return $this->view($user, $payment);
    }

    /**
     * Determine whether the user can delete the payment.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Partners\Payment  $payment
     * @return mixed
     */
    public function delete(User $user, Payment $payment)
    {
        return $this->view($user, $payment);
    }
}

<?php

namespace App\Policies;

use App\Entities\Invoices\Invoice;
use App\Entities\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the invoice.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Invoices\Invoice  $invoice
     * @return mixed
     */
    public function view(User $user, Invoice $invoice)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create invoices.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Invoices\Invoice  $invoice
     * @return mixed
     */
    public function create(User $user, Invoice $invoice)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the invoice.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Invoices\Invoice  $invoice
     * @return mixed
     */
    public function update(User $user, Invoice $invoice)
    {
        return $this->view($user, $invoice);
    }

    /**
     * Determine whether the user can delete the invoice.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Invoices\Invoice  $invoice
     * @return mixed
     */
    public function delete(User $user, Invoice $invoice)
    {
        return $this->view($user, $invoice);
    }
}

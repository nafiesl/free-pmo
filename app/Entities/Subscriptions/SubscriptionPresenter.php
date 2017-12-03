<?php

namespace App\Entities\Subscriptions;

use Laracasts\Presenter\Presenter;

class SubscriptionPresenter extends Presenter
{
    public function customerNameAndEmail()
    {
        return $this->customer_id ? $this->customer->name.' ('.$this->customer->email.')' : '-';
    }
}

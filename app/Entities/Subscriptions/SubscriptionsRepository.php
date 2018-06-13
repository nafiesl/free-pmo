<?php

namespace App\Entities\Subscriptions;

use App\Entities\BaseRepository;

/**
 * Subscriptions Repository Class.
 */
class SubscriptionsRepository extends BaseRepository
{
    /**
     * Subscription model.
     *
     * @var \App\Entities\Subscriptions\Subscription
     */
    protected $model;

    /**
     * Create SubscriptionRepository class instance.
     *
     * @param  \App\Entities\Subscriptions\Subscription  $model
     */
    public function __construct(Subscription $model)
    {
        parent::__construct($model);
    }

    /**
     * Get subscrioption list.
     *
     * @param  string  $q
     * @param  int  $customerId
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getSubscriptions($q, $customerId)
    {
        return $this->model->orderBy('status_id', 'desc')
            ->orderBy('due_date')
            ->where(function ($query) use ($q, $customerId) {
                if ($customerId) {
                    $query->where('customer_id', $customerId);
                }

                if ($q) {
                    $query->where('name', 'like', '%'.$q.'%');
                }
            })
            ->with('customer', 'vendor')
            ->paginate($this->_paginate);
    }
}

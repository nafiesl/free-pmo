<?php

namespace App\Entities\Subscriptions;

use App\Entities\BaseRepository;

/**
* Subscriptions Repository Class
*/
class SubscriptionsRepository extends BaseRepository
{
    protected $model;

    public function __construct(Subscription $model)
    {
        parent::__construct($model);
    }

    public function getSubscriptions($q, $vendorId)
    {
        return $this->model->orderBy('due_date')
            ->where(function($query) use ($q, $vendorId) {
                if ($vendorId)
                    $query->where('vendor_id', $vendorId);
                if ($q)
                    $query->where('domain_name','like','%' . $q . '%');
            })
            ->with('vendor')
            ->paginate($this->_paginate);
    }
}
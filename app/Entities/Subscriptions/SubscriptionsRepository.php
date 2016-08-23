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

    public function getAll($q)
    {
        return $this->model->orderBy('due_date')
            ->where('domain_name','like','%' . $q . '%')
            ->paginate($this->_paginate);
    }
}
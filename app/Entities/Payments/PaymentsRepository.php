<?php

namespace App\Entities\Payments;

use App\Entities\BaseRepository;

/**
* Payments Repository Class
*/
class PaymentsRepository extends BaseRepository
{
    protected $model;

    public function __construct(Payment $model)
    {
        parent::__construct($model);
    }

    public function getAll($q)
    {
        return $this->model->latest()
            ->paginate($this->_paginate);
    }
}
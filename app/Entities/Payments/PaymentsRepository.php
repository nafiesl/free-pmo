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
        return $this->model->orderBy('date','desc')
            ->whereHas('project', function($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%');
            })
            ->with('customer','project')
            ->whereOwnerId(auth()->id())
            ->paginate($this->_paginate);
    }

    public function create($paymentData)
    {
        $paymentData['owner_id'] = auth()->id();
        $paymentData['amount'] = str_replace('.', '', $paymentData['amount']);
        return $this->storeArray($paymentData);
    }

    public function update($paymentData = [], $paymentId)
    {
        foreach ($paymentData as $key => $value) {
            if (!$paymentData[$key]) $paymentData[$key] = null;
        }

        $paymentData['amount'] = str_replace('.', '', $paymentData['amount']);
        $payment = $this->requireById($paymentId);
        $payment->update($paymentData);
        return $payment;
    }
}
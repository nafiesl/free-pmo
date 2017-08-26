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

    public function getPayments($queryStrings)
    {
        return $this->model->orderBy('date','desc')
            ->whereHas('project', function($query) use ($queryStrings) {
                if (isset($queryStrings['q'])) {
                    $query->where('name', 'like', '%' . $queryStrings['q'] . '%');
                }
            })
            ->where(function ($query) use ($queryStrings) {
                if (isset($queryStrings['customer_id'])) {
                    $query->where('customer_id', $queryStrings['customer_id']);
                }
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
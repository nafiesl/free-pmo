<?php

namespace App\Entities\Payments;

use App\Entities\BaseRepository;

/**
 * Payments Repository Class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
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
        return $this->model->orderBy('date', 'desc')
            ->whereHas('project', function ($query) use ($queryStrings) {
                if (isset($queryStrings['q'])) {
                    $query->where('name', 'like', '%'.$queryStrings['q'].'%');
                }
            })
            ->where(function ($query) use ($queryStrings) {
                if (isset($queryStrings['partner_id'])) {
                    $query->where('partner_id', $queryStrings['partner_id']);
                }
            })
            ->with('partner', 'project')
            ->paginate($this->_paginate);
    }

    public function create($paymentData)
    {
        $paymentData['amount'] = str_replace('.', '', $paymentData['amount']);

        if ($paymentData['in_out'] == 0) {
            $paymentData['partner_type'] = 'App\Entities\Partners\Vendor';
        } else {
            $paymentData['partner_type'] = 'App\Entities\Partners\Customer';
        }

        return $this->storeArray($paymentData);
    }
}

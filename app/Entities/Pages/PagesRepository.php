<?php

namespace App\Entities\Pages;

use App\Entities\BaseRepository;
use App\Entities\Options\Option;
use App\Entities\Payments\Payment;

/**
* Pages Repository Class
*/
class PagesRepository extends BaseRepository
{
    public function __construct(Option $model)
    {
        $this->model = $model;
    }

    public function getTotalIncome()
    {
        return Payment::whereType(1)->sum('amount');
    }

    public function getTotalExpenditure()
    {
        return Payment::whereType(0)->sum('amount');
    }
}
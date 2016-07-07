<?php

namespace App\Entities\Masters;

use App\Entities\BaseRepository;

/**
* Masters Repository Class
*/
class MastersRepository extends BaseRepository
{
    protected $model;

    public function __construct(Master $model)
    {
        parent::__construct($model);
    }
}
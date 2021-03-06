<?php

namespace App\Events\Jobs;

use App\Entities\Projects\Job;

class Deleted
{
    public $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }
}

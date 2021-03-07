<?php

namespace App\Events\Tasks;

use App\Entities\Projects\Task;

class Created
{
    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }
}

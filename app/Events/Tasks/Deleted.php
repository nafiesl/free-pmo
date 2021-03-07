<?php

namespace App\Events\Tasks;

use App\Entities\Projects\Task;

class Deleted
{
    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }
}

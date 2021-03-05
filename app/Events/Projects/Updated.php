<?php

namespace App\Events\Projects;

use App\Entities\Projects\Project;

class Updated
{
    public $project;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }
}

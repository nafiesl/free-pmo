<?php

namespace App\Events\Projects;

use App\Entities\Projects\Project;

class Updated
{
    public $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }
}

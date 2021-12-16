<?php

namespace App\Entities\Projects;

use Laracasts\Presenter\Presenter;

class JobPresenter extends Presenter
{
    public function workerNameAndEmail()
    {
        return $this->worker_id ? $this->worker->name.' ('.$this->worker->email.')' : '-';
    }

    public function projectLink()
    {
        return link_to_route('projects.show', $this->project->name, [$this->project_id]);
    }

    public function projectJobsLink()
    {
        return link_to_route('projects.jobs.index', __('project.jobs'), [$this->project_id]);
    }
}

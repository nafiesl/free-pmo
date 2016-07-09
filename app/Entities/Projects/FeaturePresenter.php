<?php

namespace App\Entities\Projects;

use Laracasts\Presenter\Presenter;

class FeaturePresenter extends Presenter
{
    public function workerNameAndEmail()
    {
        return $this->worker_id ? $this->worker->name  . ' (' . $this->worker->email . ')' : '-';
    }

    public function projectLink()
    {
        return link_to_route('projects.show', $this->project->name, [$this->project_id]);
    }

    public function projectFeaturesLink()
    {
        return link_to_route('projects.features', trans('project.features'), [$this->project_id]);
    }

}
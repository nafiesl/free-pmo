<?php

namespace App\Entities\Projects;

use ProjectStatus;
use Laracasts\Presenter\Presenter;

class ProjectPresenter extends Presenter
{
    public function customerNameAndEmail()
    {
        return $this->customer_id ? $this->customer->name.' ('.$this->customer->email.')' : '-';
    }

    public function projectLink()
    {
        return link_to_route('projects.show', $this->name, [$this->id]);
    }

    public function status()
    {
        return ProjectStatus::getNameById($this->entity->status_id);
    }

    public function workDuration()
    {
        if (is_null($this->entity->end_date)) {
            return '-';
        }

        $workDuration = dateDifference($this->entity->start_date, $this->entity->end_date);
        if ((int) $workDuration > 30) {
            return dateDifference($this->entity->start_date, $this->entity->end_date, '%m Bulan %d Hari');
        }

        return $workDuration.' Hari';
    }
}

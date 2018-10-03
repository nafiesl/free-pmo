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
        $startDate = $this->entity->start_date;
        $endDate = $this->entity->end_date;

        if (is_null($endDate)) {
            return '-';
        }

        $workDuration = dateDifference($startDate, $endDate);
        if ((int) $workDuration > 365) {
            return dateDifference($startDate, $endDate, '%y Year(s) %m Month(s) %d Day(s)');
        } elseif ((int) $workDuration > 30) {
            return dateDifference($startDate, $endDate, '%m Month(s) %d Day(s)');
        }

        return $workDuration.' Day(s)';
    }
}

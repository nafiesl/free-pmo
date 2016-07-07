<?php

namespace App\Entities\Payments;

use Laracasts\Presenter\Presenter;

class PaymentPresenter extends Presenter
{
    public function amount()
    {
        return $this->entity->type == 0 ? formatRp(-$this->entity->amount) : formatRp($this->entity->amount);
    }

    public function projectLink()
    {
        return link_to_route('projects.show', $this->project->name, [$this->project_id]);
    }

    public function projectPaymentsLink()
    {
        return link_to_route('projects.payments', trans('project.payments'), [$this->project_id]);
    }
}
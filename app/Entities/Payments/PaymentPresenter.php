<?php

namespace App\Entities\Payments;

use Laracasts\Presenter\Presenter;

class PaymentPresenter extends Presenter
{
    public function amount()
    {
        return $this->entity->in_out == 0 ? format_money(-$this->entity->amount) : format_money($this->entity->amount);
    }

    public function projectLink()
    {
        return link_to_route('projects.show', $this->project->name, [$this->project_id]);
    }

    public function projectPaymentsLink()
    {
        return link_to_route('projects.payments', __('project.payments'), [$this->project_id]);
    }

    public function type()
    {
        return paymentTypes($this->entity->type_id);
    }
}

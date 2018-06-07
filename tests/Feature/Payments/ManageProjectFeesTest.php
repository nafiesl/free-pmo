<?php

namespace Tests\Feature\Payments;

use Tests\TestCase;
use App\Entities\Users\User;
use App\Entities\Projects\Project;

class ManageProjectFeesTest extends TestCase
{
    /** @test */
    public function admin_can_entry_project_fee_payment()
    {
        $user = $this->adminUserSigningIn();
        $worker = factory(User::class)->create();
        $project = factory(Project::class)->create();

        $this->visit(route('projects.payments', $project->id));
        $this->seePageIs(route('projects.payments', $project->id));

        $this->click(trans('payment.create_fee'));
        $this->seePageIs(route('projects.fees.create', $project->id));

        // // Fill Form
        $this->submitForm(trans('payment.create'), [
            'date'        => '2015-05-01',
            'type_id'     => 1,
            'amount'      => 1000000,
            'partner_id'  => $worker->id,
            'description' => 'Honor pengerjaan fitur a project '.$project->name,
        ]);

        $this->see(trans('payment.created'));
        $this->seePageIs(route('projects.payments', $project->id));

        $this->seeInDatabase('payments', [
            'project_id'   => $project->id,
            'amount'       => 1000000,
            'type_id'      => 1,
            'in_out'       => 0,
            'date'         => '2015-05-01',
            'partner_type' => User::class,
            'partner_id'   => $worker->id,
        ]);
    }
}

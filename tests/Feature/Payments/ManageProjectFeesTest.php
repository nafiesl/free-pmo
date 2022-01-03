<?php

namespace Tests\Feature\Payments;

use App\Entities\Payments\Payment;
use App\Entities\Projects\Project;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageProjectFeesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_entry_project_fee_payment()
    {
        $user = $this->adminUserSigningIn();
        $worker = factory(User::class)->create();
        $project = factory(Project::class)->create();

        $this->visit(route('projects.payments', $project->id));
        $this->seePageIs(route('projects.payments', $project->id));

        $this->click(__('payment.create_fee'));
        $this->seePageIs(route('projects.fees.create', $project->id));

        // // Fill Form
        $this->submitForm(__('payment.create'), [
            'date' => '2015-05-01',
            'type_id' => 1,
            'amount' => 1000000,
            'partner_id' => $worker->id,
            'description' => 'Honor pengerjaan fitur a project '.$project->name,
        ]);

        $this->see(__('payment.created'));
        $this->seePageIs(route('projects.payments', $project->id));

        $this->seeInDatabase('payments', [
            'project_id' => $project->id,
            'amount' => 1000000,
            'type_id' => 1,
            'in_out' => 0,
            'date' => '2015-05-01',
            'partner_type' => User::class,
            'partner_id' => $worker->id,
        ]);
    }

    /** @test */
    public function admin_can_edit_project_fee_payment()
    {
        $this->adminUserSigningIn();
        $worker = factory(User::class)->create();
        $project = factory(Project::class)->create();
        $payment = factory(Payment::class)->create([
            'project_id' => $project->id,
            'partner_type' => User::class,
            'partner_id' => $worker->id,
        ]);

        $this->visit(route('payments.edit', $payment));

        // Fill Form
        $this->submitForm(__('payment.update'), [
            'date' => '2015-05-01',
            'in_out' => 0,
            'type_id' => 1,
            'amount' => 1000000,
            'partner_type' => 'users',
            'partner_id' => $worker->id,
            'description' => 'Honor pengerjaan fitur a project '.$project->name,
        ]);

        $this->see(__('payment.updated'));
        $this->seePageIs(route('payments.show', $payment));

        $this->seeInDatabase('payments', [
            'project_id' => $project->id,
            'amount' => 1000000,
            'type_id' => 1,
            'in_out' => 0,
            'date' => '2015-05-01',
            'partner_type' => User::class,
            'partner_id' => $worker->id,
        ]);
    }
}

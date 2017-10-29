<?php

namespace Tests\Feature\Payments;

use App\Entities\Partners\Partner;
use App\Entities\Payments\Payment;
use App\Entities\Projects\Project;
use Tests\TestCase;

class ManagePaymentsTest extends TestCase
{
    /** @test */
    public function admin_can_entry_project_an_income_payment()
    {
        $user     = $this->adminUserSigningIn();
        $customer = factory(Partner::class)->create(['owner_id' => $user->agency->id]);
        $project  = factory(Project::class)->create(['owner_id' => $user->agency->id]);

        $this->visit(route('payments.index'));
        $this->seePageIs(route('payments.index'));
        $this->click(trans('payment.create'));

        // Fill Form
        $this->seePageIs(route('payments.create'));
        $this->type('2015-05-01', 'date');
        $this->select(1, 'in_out');
        $this->type(1000000, 'amount');
        $this->select($project->id, 'project_id');
        $this->select($customer->id, 'partner_id');
        $this->type('Pembayaran DP', 'description');
        $this->press(trans('payment.create'));

        $this->see(trans('payment.created'));
        $this->seeInDatabase('payments', [
            'project_id' => $project->id,
            'amount'     => 1000000,
            'in_out'     => 1,
            'date'       => '2015-05-01',
            'partner_id' => $customer->id,
        ]);
    }

    /** @test */
    public function admin_can_entry_project_an_expanse_payment()
    {
        $user    = $this->adminUserSigningIn();
        $vendor  = factory(Partner::class)->create(['owner_id' => $user->agency->id]);
        $project = factory(Project::class)->create(['owner_id' => $user->agency->id]);

        $this->visit(route('payments.index'));
        $this->seePageIs(route('payments.index'));
        $this->click(trans('payment.create'));

        // Fill Form
        $this->seePageIs(route('payments.create'));
        $this->type('2015-05-01', 'date');
        $this->select(0, 'in_out');
        $this->select(3, 'type_id');
        $this->type(1000000, 'amount');
        $this->select($project->id, 'project_id');
        $this->select($vendor->id, 'partner_id');
        $this->type('Pembayaran DP', 'description');
        $this->press(trans('payment.create'));

        $this->see(trans('payment.created'));
        $this->seeInDatabase('payments', [
            'project_id' => $project->id,
            'amount'     => 1000000,
            'in_out'     => 0,
            'date'       => '2015-05-01',
            'partner_id' => $vendor->id,
        ]);
    }

    /** @test */
    public function admin_can_edit_payment_data()
    {
        $user     = $this->adminUserSigningIn();
        $customer = factory(Partner::class)->create(['owner_id' => $user->agency->id]);
        $project  = factory(Project::class)->create(['owner_id' => $user->agency->id]);

        $payment = factory(Payment::class)->create([
            'partner_id' => $customer->id,
            'project_id' => $project->id,
        ]);

        $this->visit(route('payments.edit', $payment->id));
        $this->seePageIs(route('payments.edit', $payment->id));
        $this->type('2016-05-20', 'date');
        $this->select(1, 'in_out');
        $this->select(3, 'type_id');
        $this->type(1234567890, 'amount');
        $this->press(trans('payment.update'));

        $this->seePageIs(route('payments.show', $payment->id));

        $this->see(trans('payment.updated'));
        $this->seeInDatabase('payments', [
            'partner_id' => $customer->id,
            'project_id' => $project->id,
            'date'       => '2016-05-20',
            'amount'     => 1234567890,
        ]);
    }

    /** @test */
    public function admin_can_delete_a_payment()
    {
        $user     = $this->adminUserSigningIn();
        $customer = factory(Partner::class)->create(['owner_id' => $user->agency->id]);
        $project  = factory(Project::class)->create(['owner_id' => $user->agency->id, 'customer_id' => $customer->id]);
        $payment  = factory(Payment::class)->create(['project_id' => $project->id, 'partner_id' => $customer->id]);

        $this->visit(route('payments.index'));
        $this->click(trans('app.edit'));
        $this->click(trans('payment.delete'));
        $this->press(trans('app.delete_confirm_button'));
        $this->seePageIs(route('projects.payments', $payment->project_id));
        $this->see(trans('payment.deleted'));
    }

    /** @test */
    public function admin_can_see_a_payment()
    {
        $user     = $this->adminUserSigningIn();
        $customer = factory(Partner::class)->create(['owner_id' => $user->agency->id]);
        $project  = factory(Project::class)->create(['owner_id' => $user->agency->id, 'customer_id' => $customer->id]);
        $payment  = factory(Payment::class)->create(['project_id' => $project->id, 'partner_id' => $customer->id]);

        $this->visit(route('payments.index'));
        $this->click(trans('app.show'));
        $this->seePageIs(route('payments.show', $payment->id));
        $this->see(trans('payment.show'));
        $this->see($payment->date);
        $this->see(formatRp($payment->amount));
        $this->see($payment->description);
        $this->see($payment->partner->name);
    }
}

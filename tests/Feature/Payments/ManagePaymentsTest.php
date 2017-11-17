<?php

namespace Tests\Feature\Payments;

use App\Entities\Partners\Customer;
use App\Entities\Partners\Vendor;
use App\Entities\Payments\Payment;
use App\Entities\Projects\Project;
use Tests\TestCase;

/**
 * Manage Payments Feature Test
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class ManagePaymentsTest extends TestCase
{
    /** @test */
    public function admin_can_entry_project_an_income_payment()
    {
        $user = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create();
        $project = factory(Project::class)->create();

        $this->visit(route('payments.create'));
        $this->seePageIs(route('payments.create'));

        // Fill Form
        $this->submitForm(trans('payment.create'), [
            'date'        => '2015-05-01',
            'in_out'      => 1,
            'type_id'     => 1,
            'amount'      => 1000000,
            'project_id'  => $project->id,
            'partner_id'  => $customer->id,
            'description' => 'Pembayaran DP',
        ]);

        $this->see(trans('payment.created'));

        $this->seeInDatabase('payments', [
            'project_id'   => $project->id,
            'amount'       => 1000000,
            'type_id'      => 1,
            'in_out'       => 1,
            'date'         => '2015-05-01',
            'partner_type' => Customer::class,
            'partner_id'   => $customer->id,
        ]);
    }

    /** @test */
    public function admin_can_entry_project_an_expanse_payment()
    {
        $user = $this->adminUserSigningIn();
        $vendor = factory(Vendor::class)->create();
        $project = factory(Project::class)->create();

        $this->visit(route('payments.create'));
        $this->seePageIs(route('payments.create'));

        // Fill Form
        $this->submitForm(trans('payment.create'), [
            'date'        => '2015-05-01',
            'in_out'      => 0,
            'type_id'     => 3,
            'amount'      => 1000000,
            'project_id'  => $project->id,
            'partner_id'  => $vendor->id,
            'description' => 'Pembayaran DP',
        ]);

        $this->see(trans('payment.created'));

        $this->seeInDatabase('payments', [
            'project_id'   => $project->id,
            'amount'       => 1000000,
            'in_out'       => 0,
            'date'         => '2015-05-01',
            'partner_type' => Vendor::class,
            'partner_id'   => $vendor->id,
        ]);
    }

    /** @test */
    public function admin_can_edit_payment_data()
    {
        $user = $this->adminUserSigningIn();

        $payment = factory(Payment::class)->create();

        $this->visit(route('payments.edit', $payment->id));
        $this->seePageIs(route('payments.edit', $payment->id));

        $this->submitForm(trans('payment.update'), [
            'date'        => '2016-05-20',
            'in_out'      => 0,
            'type_id'     => 3,
            'amount'      => 1000000,
            'description' => 'Pembayaran DP',
        ]);

        $this->seePageIs(route('payments.show', $payment->id));

        $this->see(trans('payment.updated'));
        $this->seeInDatabase('payments', [
            'date'   => '2016-05-20',
            'amount' => 1000000,
        ]);
    }

    /** @test */
    public function admin_can_delete_a_payment()
    {
        $user = $this->adminUserSigningIn();
        $payment = factory(Payment::class)->create();

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
        $user = $this->adminUserSigningIn();
        $payment = factory(Payment::class)->create();

        $this->visit(route('payments.index'));
        $this->click(trans('app.show'));
        $this->seePageIs(route('payments.show', $payment->id));
        $this->see(trans('payment.detail'));
        $this->see($payment->date);
        $this->see(formatRp($payment->amount));
        $this->see($payment->description);
        $this->see($payment->partner->name);
    }
}

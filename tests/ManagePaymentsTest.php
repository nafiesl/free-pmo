<?php

use App\Entities\Payments\Payment;
use App\Entities\Projects\Project;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ManagePaymentsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function admin_can_entry_project_a_payment()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $project = factory(Project::class)->create();

        $customer = factory(User::class)->create();
        $customer->assignRole('customer');

        $this->visit('payments');
        $this->seePageIs('payments');
        $this->click(trans('payment.create'));

        // Fill Form
        $this->seePageIs('payments/create');
        $this->type('2015-05-01','date');
        $this->select(1,'type');
        $this->type(1000000,'amount');
        $this->select($project->id, 'project_id');
        $this->select($customer->id, 'customer_id');
        $this->type('Pembayaran DP','description');
        $this->press(trans('payment.create'));

        $this->see(trans('payment.created'));
        $this->seeInDatabase('payments', ['project_id' => $project->id,'amount' => 1000000,'type' => 1,'date' => '2015-05-01']);
    }

    /** @test */
    public function admin_can_edit_payment_data()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $project = factory(Project::class)->create();

        $customer = factory(User::class)->create();
        $customer->assignRole('customer');

        $payment = factory(Payment::class)->create(['customer_id' => $customer->id, 'project_id' => $project->id]);

        $this->visit('payments/' . $payment->id . '/edit');
        $this->seePageIs('payments/' . $payment->id . '/edit');
        $this->type('2016-05-20','date');
        $this->select(1, 'type');
        $this->type(1234567890,'amount');
        $this->press(trans('payment.update'));

        $this->seePageIs('payments/' . $payment->id . '/edit');
        $this->see(trans('payment.updated'));
        $this->seeInDatabase('payments', [
            'customer_id' => $customer->id,
            'project_id' => $project->id,
            'date' => '2016-05-20',
            'amount' => 1234567890,
        ]);
    }

    /** @test */
    public function admin_can_delete_a_payment()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $payment = factory(Payment::class)->create();
        $this->visit('/payments');
        $this->click(trans('app.edit'));
        $this->click(trans('payment.delete'));
        $this->press(trans('app.delete_confirm_button'));
        $this->seePageIs('payments');
        $this->see(trans('payment.deleted'));
    }
}

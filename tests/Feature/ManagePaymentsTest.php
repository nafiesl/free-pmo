<?php

namespace Tests\Feature;

use App\Entities\Payments\Payment;
use App\Entities\Projects\Project;
use App\Entities\Users\User;
use Tests\TestCase;

class ManagePaymentsTest extends TestCase
{
    /** @test */
    public function admin_can_entry_project_a_cashin_payment()
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
        $this->select(1,'in_out');
        $this->type(1000000,'amount');
        $this->select($project->id, 'project_id');
        $this->select($customer->id, 'customer_id');
        $this->type('Pembayaran DP','description');
        $this->press(trans('payment.create'));

        $this->see(trans('payment.created'));
        $this->seeInDatabase('payments', ['project_id' => $project->id,'amount' => 1000000,'in_out' => 1,'date' => '2015-05-01']);
    }


    /** @test */
    public function admin_can_entry_project_a_cashout_payment()
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
        $this->select(0,'in_out');
        $this->select(3,'type_id');
        $this->type(1000000,'amount');
        $this->select($project->id, 'project_id');
        $this->select($customer->id, 'customer_id');
        $this->type('Pembayaran DP','description');
        $this->press(trans('payment.create'));

        $this->see(trans('payment.created'));
        $this->seeInDatabase('payments', ['project_id' => $project->id,'amount' => 1000000,'in_out' => 0,'date' => '2015-05-01']);
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

        $payment = factory(Payment::class)->create(['customer_id' => $customer->id, 'project_id' => $project->id, 'owner_id' => $user->id]);

        $this->visit('payments/' . $payment->id . '/edit');
        $this->seePageIs('payments/' . $payment->id . '/edit');
        $this->type('2016-05-20','date');
        $this->select(1, 'in_out');
        $this->select(3,'type_id');
        $this->type(1234567890,'amount');
        $this->press(trans('payment.update'));

        $this->seePageIs('payments/' . $payment->id);
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

        $payment = factory(Payment::class)->create(['owner_id' => $user->id]);
        $this->visit('/payments');
        $this->click(trans('app.edit'));
        $this->click(trans('payment.delete'));
        $this->press(trans('app.delete_confirm_button'));
        $this->seePageIs('projects/' . $payment->project_id . '/payments');
        $this->see(trans('payment.deleted'));
    }

    /** @test */
    public function admin_can_see_a_payment()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $project = factory(Project::class)->create(['owner_id' => $user->id]);
        $payment = factory(Payment::class)->create(['project_id' => $project->id,'owner_id' => $user->id]);

        $this->visit('/payments');
        $this->click('Lihat');
        $this->seePageIs('payments/' . $payment->id);
        $this->see(trans('payment.show'));
        $this->see($payment->date);
        $this->see(formatRp($payment->amount));
        $this->see($payment->description);
        $this->see($payment->customer->name);
    }

    // /** @test */
    // public function admin_can_see_all_payments()
    // {
    //     $user = factory(User::class)->create();
    //     $user->assignRole('admin');
    //     $this->actingAs($user);

    //     $payments = factory(Payment::class, 5)->create(['owner_id' => $user->id]);
    //     $this->assertEquals(5, $payments->count());

    //     $this->visit(route('payments.index'));
    //     $this->seePageIs(route('payments.index'));
    //     $this->see($payments[4]->project->name);
    //     $this->see($payments[4]->date);
    //     $this->see(formatRp($payments[4]->amount));
    //     $this->see($payments[4]->customer->name);
    // }

    /** @test */
    public function admin_can_search_payment_by_customer_name()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $payments = factory(Payment::class, 2)->create(['owner_id' => $user->id]);
        $this->assertEquals(2, $payments->count());

        $this->visit(route('payments.index'));

        $firstName = explode(' ', $payments[0]->project->name)[0];

        $this->type($firstName, 'q');
        $this->press(trans('payment.search'));
        $this->seePageIs(route('payments.index', ['q' => $firstName]));
        $this->see($payments[0]->project->name);
    }
}

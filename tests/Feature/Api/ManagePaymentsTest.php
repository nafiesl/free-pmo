<?php

namespace Tests\Feature\Api;

use App\Entities\Partners\Customer;
use App\Entities\Partners\Vendor;
use App\Entities\Payments\Payment;
use App\Entities\Projects\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagePaymentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_list_payments()
    {
        $user = $this->createUser('admin');
        factory(Payment::class)->create();

        $this->getJson(route('api.payments.index'), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
    }

    /** @test */
    public function admin_can_show_payment()
    {
        $user = $this->createUser('admin');
        $payment = factory(Payment::class)->create();

        $this->getJson(route('api.payments.show', $payment), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['id' => $payment->id]);
    }

    /** @test */
    public function admin_can_create_payment()
    {
        $user = $this->createUser('admin');
        $project = factory(Project::class)->create();
        $customer = factory(Customer::class)->create();

        $this->postJson(route('api.payments.store'), [
            'date' => '2026-08-01',
            'in_out' => 1,
            'amount' => 1500000,
            'project_id' => $project->id,
            'type_id' => 1,
            'partner_id' => $customer->id,
            'description' => 'Payment for project',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(201);
        $this->seeJson(['message' => __('payment.created')]);
        $this->seeInDatabase('payments', ['amount' => 1500000]);
    }

    /** @test */
    public function admin_can_update_payment()
    {
        $user = $this->createUser('admin');
        $payment = factory(Payment::class)->create(['amount' => 10000]);

        $this->patchJson(route('api.payments.update', $payment), [
            'amount' => 20000,
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('payment.updated')]);
        $this->seeInDatabase('payments', ['id' => $payment->id, 'amount' => 20000]);
    }

    /** @test */
    public function admin_can_delete_payment()
    {
        $user = $this->createUser('admin');
        $payment = factory(Payment::class)->create();

        $this->deleteJson(route('api.payments.destroy', $payment), [], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('payment.deleted')]);
        $this->dontSeeInDatabase('payments', ['id' => $payment->id]);
    }

    /** @test */
    public function payment_amount_strips_dots()
    {
        $user = $this->createUser('admin');
        $project = factory(Project::class)->create();
        $customer = factory(Customer::class)->create();

        $this->postJson(route('api.payments.store'), [
            'date' => '2026-08-01',
            'in_out' => 1,
            'amount' => '1.500.000',
            'project_id' => $project->id,
            'type_id' => 1,
            'partner_id' => $customer->id,
            'description' => 'Payment for project',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(201);
        $this->seeInDatabase('payments', ['amount' => 1500000]);
    }

    /** @test */
    public function payment_partner_type_set_by_in_out()
    {
        $user = $this->createUser('admin');
        $project = factory(Project::class)->create();
        $vendor = factory(Vendor::class)->create();

        $this->postJson(route('api.payments.store'), [
            'date' => '2026-08-01',
            'in_out' => 0,
            'amount' => 500000,
            'project_id' => $project->id,
            'type_id' => 1,
            'partner_id' => $vendor->id,
            'description' => 'Expense payment',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(201);
        $this->seeInDatabase('payments', [
            'in_out' => 0,
            'partner_type' => Vendor::class,
            'partner_id' => $vendor->id,
        ]);
    }

    /** @test */
    public function worker_cannot_create_payment()
    {
        $user = $this->createUser('worker');
        $project = factory(Project::class)->create();
        $customer = factory(Customer::class)->create();

        $this->postJson(route('api.payments.store'), [
            'date' => '2026-08-01',
            'in_out' => 1,
            'amount' => 1500000,
            'project_id' => $project->id,
            'type_id' => 1,
            'partner_id' => $customer->id,
            'description' => 'Payment for project',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(403);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_payments()
    {
        $this->getJson(route('api.payments.index'));

        $this->seeStatusCode(401);
    }
}

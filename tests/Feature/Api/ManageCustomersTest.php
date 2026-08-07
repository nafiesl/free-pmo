<?php

namespace Tests\Feature\Api;

use App\Entities\Partners\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageCustomersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_list_customers()
    {
        $user = $this->createUser('admin');
        factory(Customer::class)->create();

        $this->getJson(route('api.customers.list'), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
    }

    /** @test */
    public function admin_can_show_customer()
    {
        $user = $this->createUser('admin');
        $customer = factory(Customer::class)->create();

        $this->getJson(route('api.customers.show', $customer), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['id' => $customer->id]);
    }

    /** @test */
    public function admin_can_update_customer()
    {
        $user = $this->createUser('admin');
        $customer = factory(Customer::class)->create(['name' => 'Old Name']);

        $this->patchJson(route('api.customers.update', $customer), [
            'name' => 'Updated Customer',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('customer.updated')]);
        $this->seeInDatabase('customers', ['id' => $customer->id, 'name' => 'Updated Customer']);
    }

    /** @test */
    public function admin_can_delete_customer()
    {
        $user = $this->createUser('admin');
        $customer = factory(Customer::class)->create();

        $this->deleteJson(route('api.customers.destroy', $customer), [], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('customer.deleted')]);
        $this->dontSeeInDatabase('customers', ['id' => $customer->id]);
    }

    /** @test */
    public function worker_cannot_update_customer()
    {
        $user = $this->createUser('worker');
        $customer = factory(Customer::class)->create();

        $this->patchJson(route('api.customers.update', $customer), [
            'name' => 'Updated Customer',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(403);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_customers()
    {
        $this->getJson(route('api.customers.list'));

        $this->seeStatusCode(401);
    }
}

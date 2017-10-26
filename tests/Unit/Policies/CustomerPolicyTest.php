<?php

namespace Tests\Unit\Policies;

use App\Entities\Partners\Customer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class CustomerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_create_customer()
    {
        $user = $this->adminUserSigningIn();
        $this->assertTrue($user->can('create', new Customer));
    }

    /** @test */
    public function user_can_view_customer()
    {
        $user = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create(['name' => 'Customer 1 name']);
        $this->assertTrue($user->can('view', $customer));
    }

    /** @test */
    public function user_can_update_customer()
    {
        $user = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create(['name' => 'Customer 1 name']);
        $this->assertTrue($user->can('update', $customer));
    }

    /** @test */
    public function user_can_delete_customer()
    {
        $user = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create(['name' => 'Customer 1 name']);
        $this->assertTrue($user->can('delete', $customer));
    }
}

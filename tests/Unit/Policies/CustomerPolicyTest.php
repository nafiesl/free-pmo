<?php

namespace Tests\Unit\Policies;

use App\Entities\Partners\Customer;
use Tests\TestCase as TestCase;

/**
 * Customer Policy Test.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class CustomerPolicyTest extends TestCase
{
    /** @test */
    public function only_admin_can_create_customer()
    {
        $admin = $this->createUser('admin');
        $this->assertTrue($admin->can('create', new Customer()));

        $worker = $this->createUser('worker');
        $this->assertFalse($worker->can('create', new Customer()));
    }

    /** @test */
    public function only_admin_can_view_customer()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');
        $customer = factory(Customer::class)->create();

        $this->assertTrue($admin->can('view', $customer));
        $this->assertFalse($worker->can('view', $customer));
    }

    /** @test */
    public function only_admin_can_update_customer()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');
        $customer = factory(Customer::class)->create();

        $this->assertTrue($admin->can('update', $customer));
        $this->assertFalse($worker->can('update', $customer));
    }

    /** @test */
    public function only_admin_can_delete_customer()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');
        $customer = factory(Customer::class)->create();

        $this->assertTrue($admin->can('delete', $customer));
        $this->assertFalse($worker->can('delete', $customer));
    }
}

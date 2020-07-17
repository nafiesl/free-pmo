<?php

namespace Tests\Unit\Policies;

use App\Entities\Payments\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Payment Policy Test.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class PaymentPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_admin_can_create_payment()
    {
        $admin = $this->createUser('admin');
        $this->assertTrue($admin->can('create', new Payment()));

        $worker = $this->createUser('worker');
        $this->assertFalse($worker->can('create', new Payment()));
    }

    /** @test */
    public function only_admin_can_view_payment()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');
        $payment = factory(Payment::class)->create();

        $this->assertTrue($admin->can('view', $payment));
        $this->assertFalse($worker->can('view', $payment));
    }

    /** @test */
    public function only_admin_can_update_payment()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');
        $payment = factory(Payment::class)->create();

        $this->assertTrue($admin->can('update', $payment));
        $this->assertFalse($worker->can('update', $payment));
    }

    /** @test */
    public function only_admin_can_delete_payment()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');
        $payment = factory(Payment::class)->create();

        $this->assertTrue($admin->can('delete', $payment));
        $this->assertFalse($worker->can('delete', $payment));
    }
}

<?php

namespace Tests\Unit\Policies;

use App\Entities\Partners\Vendor;
use App\Entities\Payments\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Vendor Policy Test.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class VendorPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_admin_can_create_vendor()
    {
        $admin = $this->createUser('admin');
        $this->assertTrue($admin->can('create', new Vendor()));

        $worker = $this->createUser('worker');
        $this->assertFalse($worker->can('create', new Vendor()));
    }

    /** @test */
    public function only_admin_can_view_vendor()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');
        $vendor = factory(Vendor::class)->create();

        $this->assertTrue($admin->can('view', $vendor));
        $this->assertFalse($worker->can('view', $vendor));
    }

    /** @test */
    public function only_admin_can_update_vendor()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');
        $vendor = factory(Vendor::class)->create();

        $this->assertTrue($admin->can('update', $vendor));
        $this->assertFalse($worker->can('update', $vendor));
    }

    /** @test */
    public function only_admin_can_delete_vendor()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');
        $vendor = factory(Vendor::class)->create();

        $this->assertTrue($admin->can('delete', $vendor));
        $this->assertFalse($worker->can('delete', $vendor));
    }

    /** @test */
    public function admin_cannot_delete_vendor_if_it_has_dependent_records()
    {
        $admin = $this->createUser('admin');
        $vendor = factory(Vendor::class)->create();
        $this->assertTrue($admin->can('delete', $vendor));

        $payment = factory(Payment::class)->create([
            'partner_type' => Vendor::class,
            'partner_id'   => $vendor->id,
        ]);

        $this->assertFalse($admin->can('delete', $vendor->fresh()));
    }
}

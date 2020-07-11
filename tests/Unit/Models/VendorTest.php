<?php

namespace Tests\Unit\Models;

use App\Entities\Partners\Vendor;
use App\Entities\Payments\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class VendorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_vendor_has_name()
    {
        $vendor = factory(Vendor::class)->make(['name' => 'Vendor 1 name']);
        $this->assertEquals('Vendor 1 name', $vendor->name);
    }

    /** @test */
    public function a_vendor_has_morph_many_payments_relation()
    {
        $vendor = factory(Vendor::class)->create();
        $payment = factory(Payment::class)->create([
            'partner_id'   => $vendor->id,
            'partner_type' => 'App\Entities\Partners\Vendor',
        ]);

        $this->assertInstanceOf(Collection::class, $vendor->payments);
        $this->assertInstanceOf(Payment::class, $vendor->payments->first());
    }

    /** @test */
    public function a_vendor_has_status_attribute()
    {
        $vendor = factory(Vendor::class)->make(['is_active' => 1]);
        $this->assertEquals(__('app.active'), $vendor->status);

        $vendor->is_active = 0;
        $this->assertEquals(__('app.in_active'), $vendor->status);
    }
}

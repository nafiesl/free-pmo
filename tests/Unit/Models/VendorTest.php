<?php

namespace Tests\Unit\Models;

use App\Entities\Partners\Vendor;
use App\Entities\Payments\Payment;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase as TestCase;

class VendorTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_vendor_has_name()
    {
        $vendor = factory(Vendor::class)->make(['name' => 'Vendor 1 name']);
        $this->assertEquals('Vendor 1 name', $vendor->name);
    }

    /** @test */
    public function a_vendor_has_many_payments_relation()
    {
        $vendor = factory(Vendor::class)->create();
        $payment = factory(Payment::class)->create(['partner_id' => $vendor->id]);

        $this->assertInstanceOf(Collection::class, $vendor->payments);
        $this->assertInstanceOf(Payment::class, $vendor->payments->first());
    }
}

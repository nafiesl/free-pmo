<?php

namespace Tests\Unit\Models;

use App\Entities\Partners\Vendor;
use Illuminate\Foundation\Testing\DatabaseMigrations;
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
}

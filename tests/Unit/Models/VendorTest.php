<?php

namespace Tests\Unit\Models;

use App\Entities\Agencies\Agency;
use App\Entities\Partners\Vendor;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class VendorTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_vendor_belongs_to_an_agency_as_its_owner()
    {
        $vendor = factory(Vendor::class)->create();
        $this->assertTrue(
            $vendor->owner instanceof Agency,
            'A vendor must belongs to an App\Entities\Agencies\Agency model as its owner.'
        );
    }
}

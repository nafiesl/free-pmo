<?php

namespace Tests\Unit\Models;

use App\Entities\Partners\Vendor;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class VendorTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_has_name_attribute()
    {
        $vendor = factory(Vendor::class)->create(['name' => 'Vendor 1 name']);
        $this->assertEquals('Vendor 1 name', $vendor->name);
    }
}

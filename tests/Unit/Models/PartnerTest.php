<?php

namespace Tests\Unit\Models;

use App\Entities\Partners\Partner;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class PartnerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_has_name_attribute()
    {
        $partner = factory(Partner::class)->create(['name' => 'Partner 1 name']);
        $this->assertEquals('Partner 1 name', $partner->name);
    }
}

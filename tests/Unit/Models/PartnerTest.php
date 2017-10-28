<?php

namespace Tests\Unit\Models;

use App\Entities\Agencies\Agency;
use App\Entities\Partners\Partner;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class PartnerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_partner_has_an_owner()
    {
        $agency  = factory(Agency::class)->create();
        $partner = factory(Partner::class)->create(['owner_id' => $agency->id]);

        $this->assertTrue($partner->owner instanceof Agency);
        $this->assertEquals($partner->owner->id, $agency->id);
    }
}

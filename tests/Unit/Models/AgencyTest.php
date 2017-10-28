<?php

namespace Tests\Unit\Models;

use App\Entities\Agencies\Agency;
use App\Entities\Users\User;
use Tests\TestCase;

class AgencyTest extends TestCase
{
    /** @test */
    public function agency_has_an_owner()
    {
        $agency = factory(Agency::class)->create();
        $this->assertTrue($agency->owner instanceof User);
    }
}

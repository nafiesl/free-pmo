<?php

namespace Tests\Unit\Policies;

use App\Entities\Agencies\Agency;
use Tests\TestCase as TestCase;

class AgencyPolicyTest extends TestCase
{
    /** @test */
    public function user_can_manage_owned_agency()
    {
        $user = $this->createUser();
        factory(Agency::class)->create(['owner_id' => $user->id]);

        $this->assertTrue($user->can('manage', $user->agency));
    }
}

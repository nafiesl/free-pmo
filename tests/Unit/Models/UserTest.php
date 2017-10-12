<?php

namespace Tests\Unit\Models;

use App\Entities\Users\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_has_name_link_method()
    {
        $user = factory(User::class)->create();

        $this->assertEquals(link_to_route('users.show', $user->name, [$user->id], [
            'target' => '_blank'
        ]), $user->nameLink());
    }
}

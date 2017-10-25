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
            'target' => '_blank',
        ]), $user->nameLink());
    }

    /** @test */
    public function it_can_assigned_to_a_role()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');

        $this->assertTrue($user->hasRole('admin'));
    }

    /** @test */
    public function it_has_many_roles()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $user->assignRole('worker');

        $this->assertTrue($user->hasRoles(['admin', 'worker']));
    }

    /** @test */
    public function it_can_be_removed_from_a_role()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $user->assignRole('worker');

        $this->assertTrue($user->hasRoles(['admin', 'worker']));

        $user->removeRole('worker');
        $this->assertFalse($user->fresh()->hasRole('worker'));
    }

    /** @test */
    public function it_can_queried_by_roles()
    {
        $user = factory(User::class)->create();
        $user->assignRole('vendor');
        $user->assignRole('worker');

        $this->assertCount(1, User::orderBy('name')->hasRoles(['vendor', 'worker'])->get());
    }
}

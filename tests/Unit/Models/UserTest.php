<?php

namespace Tests\Unit\Models;

use App\Entities\Agencies\Agency;
use App\Entities\Users\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function user_has_name_link_method()
    {
        $user = factory(User::class)->create();

        $this->assertEquals(link_to_route('users.show', $user->name, [$user->id], [
            'target' => '_blank',
        ]), $user->nameLink());
    }

    /** @test */
    public function user_can_assigned_to_a_role()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');

        $this->assertTrue($user->hasRole('admin'));
    }

    /** @test */
    public function user_has_many_roles()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $user->assignRole('worker');

        $this->assertTrue($user->hasRoles(['admin', 'worker']));
    }

    /** @test */
    public function user_can_be_removed_from_a_role()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $user->assignRole('worker');

        $this->assertTrue($user->hasRoles(['admin', 'worker']));

        $user->removeRole('worker');
        $this->assertFalse($user->fresh()->hasRole('worker'));
    }

    /** @test */
    public function user_can_queried_by_roles()
    {
        $user = factory(User::class)->create();
        $user->assignRole('worker');

        $this->assertCount(1, User::orderBy('name')->hasRoles(['worker'])->get());
    }

    /** @test */
    public function user_can_owns_one_agency()
    {
        $user   = factory(User::class)->create();
        $agency = factory(Agency::class)->create(['owner_id' => $user->id]);

        $this->assertTrue($user->agency instanceof Agency);
        $this->assertEquals($user->agency->id, $agency->id);
    }
}

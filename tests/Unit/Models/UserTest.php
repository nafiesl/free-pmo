<?php

namespace Tests\Unit\Models;

use App\Entities\Users\User;
use Tests\TestCase;

/**
 * User Model Unit Test
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
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

        $this->assertEquals([
            [
                'user_id' => $user->id,
                'role_id' => 1,
                'name'    => trans('user.roles.admin'),
            ],
            [
                'user_id' => $user->id,
                'role_id' => 2,
                'name'    => trans('user.roles.worker'),
            ],
        ], $user->roles->toArray());
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
    public function user_has_role_list_method()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $user->assignRole('worker');

        $roleList = '<ul>';
        $roleList .= '<li>'.trans('user.roles.admin').'</li>';
        $roleList .= '<li>'.trans('user.roles.worker').'</li>';
        $roleList .= '</ul>';

        $this->assertEquals($roleList, $user->roleList());
    }
}

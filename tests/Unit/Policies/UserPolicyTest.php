<?php

namespace Tests\Unit\Policies;

use App\Entities\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class UserPolicyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function admin_can_create_user()
    {
        $admin = $this->adminUserSigningIn();

        $this->assertTrue($admin->can('create', new User()));
    }

    /** @test */
    public function admin_can_view_user()
    {
        $admin = $this->adminUserSigningIn();
        $user = factory(User::class)->create();

        $this->assertTrue($admin->can('view', $user));
    }

    /** @test */
    public function admin_can_update_user()
    {
        $admin = $this->adminUserSigningIn();
        $user = factory(User::class)->create();

        $this->assertTrue($admin->can('update', $user));
    }

    /** @test */
    public function admin_can_delete_user()
    {
        $admin = $this->adminUserSigningIn();
        $user = factory(User::class)->create();

        $this->assertTrue($admin->can('delete', $user));
    }
}

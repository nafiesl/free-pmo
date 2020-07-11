<?php

namespace Tests\Unit\Policies;

use App\Entities\Payments\Payment;
use App\Entities\Projects\Job;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPolicyTest extends TestCase
{
    use RefreshDatabase;

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

    /** @test */
    public function admin_cannot_delete_a_user_if_user_has_been_involved_on_any_project()
    {
        $admin = $this->adminUserSigningIn();
        $user = factory(User::class)->create();
        $job = factory(Job::class)->create(['worker_id' => $user->id]);

        $this->assertFalse($admin->can('delete', $user));
    }

    /** @test */
    public function admin_cannot_delete_a_user_if_user_has_been_paid()
    {
        $admin = $this->adminUserSigningIn();
        $user = factory(User::class)->create();
        $payment = factory(Payment::class)->create([
            'partner_type' => 'App\Entities\Users\User',
            'partner_id'   => $user->id,
        ]);

        $this->assertFalse($admin->can('delete', $user));
    }
}

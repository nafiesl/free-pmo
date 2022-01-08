<?php

namespace Tests\Unit\Models;

use App\Entities\Payments\Payment;
use App\Entities\Projects\Job;
use App\Entities\Projects\Project;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

/**
 * User Model Unit Test.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_has_name_link_method()
    {
        $user = factory(User::class)->create();

        $this->assertEquals(link_to_route('users.show', $user->name, [$user]), $user->nameLink());
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
                'name' => __('user.roles.admin'),
            ],
            [
                'user_id' => $user->id,
                'role_id' => 2,
                'name' => __('user.roles.worker'),
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
        $roleList .= '<li>'.__('user.roles.admin').'</li>';
        $roleList .= '<li>'.__('user.roles.worker').'</li>';
        $roleList .= '</ul>';

        $this->assertEquals($roleList, $user->roleList());
    }

    /** @test */
    public function a_user_has_many_jobs_relation()
    {
        $user = factory(User::class)->create();
        $job = factory(Job::class)->create(['worker_id' => $user->id]);

        $this->assertInstanceOf(Collection::class, $user->jobs);
        $this->assertInstanceOf(Job::class, $user->jobs->first());
    }

    /** @test */
    public function a_user_belongs_many_projects()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create(['worker_id' => $user->id, 'project_id' => $project->id]);

        $this->assertInstanceOf(Collection::class, $user->projects);
        $this->assertInstanceOf(Project::class, $user->projects->first());
    }

    /** @test */
    public function user_project_relation_has_has_unique_project_list()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create(['worker_id' => $user->id, 'project_id' => $project->id]);
        $job = factory(Job::class)->create(['worker_id' => $user->id, 'project_id' => $project->id]);

        $this->assertInstanceOf(Collection::class, $user->projects);
        $this->assertInstanceOf(Project::class, $user->projects->first());
        $this->assertCount(1, $user->projects);
    }

    /** @test */
    public function a_user_has_many_payments_with_morph_relation()
    {
        $user = factory(User::class)->create();
        $payment = factory(Payment::class)->create([
            'partner_type' => 'App\Entities\Users\User',
            'partner_id' => $user->id,
        ]);

        $this->assertInstanceOf(Collection::class, $user->payments);
        $this->assertInstanceOf(Payment::class, $user->payments->first());
        $this->assertCount(1, $user->payments);
    }
}

<?php

use App\Entities\Projects\Feature;
use App\Entities\Projects\Project;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ManageFeaturesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function admin_can_entry_feature()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $project = factory(Project::class)->create(['owner_id' => $user->id]);

        $worker = factory(User::class)->create();
        $worker->assignRole('worker');

        $this->visit('projects/' . $project->id . '/features');
        $this->seePageIs('projects/' . $project->id . '/features');
        $this->see(trans('project.features'));
        $this->click(trans('feature.create'));
        $this->seePageIs('projects/' . $project->id . '/features/create');

        // Fill Form
        $this->type('Nama Fitur Baru','name');
        $this->type(100000,'price');
        $this->select($worker->id, 'worker_id');
        $this->select(1, 'type_id');
        $this->type('Similique, eligendi fuga animi? Ipsam magnam laboriosam distinctio officia facere sapiente eius corporis','description');
        $this->press(trans('feature.create'));

        $this->seePageIs('projects/' . $project->id . '/features');
        $this->see(trans('feature.created'));
        $this->seeInDatabase('features', [
            'name' => 'Nama Fitur Baru',
            'price' => 100000,
            'worker_id' => $worker->id,
            'type_id' => 1,
            'project_id' => $project->id
        ]);
    }

    /** @test */
    public function admin_can_edit_feature_data()
    {
        $user = factory(User::class, 3)->create();
        $user[0]->assignRole('admin');
        $user[1]->assignRole('worker');
        $user[2]->assignRole('worker');
        $this->actingAs($user[0]);

        $project = factory(Project::class)->create(['owner_id' => $user[0]->id]);

        $feature = factory(Feature::class)->create(['worker_id' => $user[1]->id, 'project_id' => $project->id]);

        $this->visit('features/' . $feature->id . '/edit');
        $this->seePageIs('features/' . $feature->id . '/edit');

        // Fill Form
        $this->type('Nama Fitur Edit','name');
        $this->type(33333,'price');
        $this->select($user[2]->id,'worker_id');
        $this->select(2, 'type_id');
        $this->press(trans('feature.update'));

        $this->seePageIs('projects/' . $project->id . '/features');
        $this->see(trans('feature.updated'));
        $this->seeInDatabase('features', [
            'name' => 'Nama Fitur Edit',
            'price' => 33333,
            'worker_id' => $user[2]->id,
            'project_id' => $project->id,
            'type_id' => 2
        ]);
    }

    /** @test */
    public function admin_can_delete_a_feature()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $project = factory(Project::class)->create(['owner_id' => $user->id]);
        $feature = factory(Feature::class)->create(['project_id' => $project->id]);

        $this->visit('projects/' . $feature->project_id . '/features');
        $this->click(trans('app.show'));
        $this->click(trans('app.edit'));
        $this->click(trans('feature.delete'));
        $this->press(trans('app.delete_confirm_button'));
        $this->seePageIs('projects/' . $project->id . '/features');
        $this->see(trans('feature.deleted'));
    }

    /** @test */
    public function admin_can_see_a_feature()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $project = factory(Project::class)->create(['owner_id' => $user->id]);
        $feature = factory(Feature::class)->create(['project_id' => $project->id]);

        $this->visit('projects/' . $project->id . '/features');
        $this->click(trans('app.show'));
        $this->seePageIs('features/' . $feature->id);
        $this->see(trans('feature.show'));
        $this->see($feature->name);
        $this->see(formatRp($feature->price));
        $this->see($feature->worker->name);
    }

    /** @test */
    public function admin_can_see_all_features()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $project = factory(Project::class)->create(['owner_id' => $user->id]);
        $features = factory(Feature::class, 5)->create(['project_id' => $project->id]);
        $this->assertEquals(5, $features->count());

        $this->visit('projects/' . $project->id . '/features');
        $this->see($features[1]->name);
        $this->see($features[1]->worker->name);
        $this->see(formatRp($features[1]->price));
    }
}

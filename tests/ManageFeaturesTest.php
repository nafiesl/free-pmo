<?php

use App\Entities\Projects\Feature;
use App\Entities\Projects\Project;
use App\Entities\Projects\Task;
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
        $tasks = factory(Task::class, 2)->create(['feature_id' => $feature->id]);

        $this->seeInDatabase('features', [
            'name' => $feature->name,
            'price' => $feature->price,
            'project_id' => $project->id,
        ]);

        // $this->visit('projects/' . $project->id . '/features');
        // $this->seePageIs('projects/' . $project->id . '/features');
        // $this->click('show-feature-' . $feature->id);
        // $this->dump();
        $this->visit('features/' . $feature->id);
        $this->seePageIs('features/' . $feature->id);
        // die('hit');
        $this->click(trans('app.edit'));
        $this->click(trans('feature.delete'));
        $this->press(trans('app.delete_confirm_button'));
        $this->seePageIs('projects/' . $project->id . '/features');
        $this->see(trans('feature.deleted'));

        $this->notSeeInDatabase('features', [
            'name' => $feature->name,
            'price' => $feature->price,
            'project_id' => $project->id,
        ]);

        $this->notSeeInDatabase('tasks', [
            'feature_id' => $feature->id,
        ]);
    }

    /** @test */
    public function admin_can_see_a_feature()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $project = factory(Project::class)->create(['owner_id' => $user->id]);
        $feature = factory(Feature::class)->create(['project_id' => $project->id,'type_id' => 1]);

        $this->visit('projects/' . $project->id . '/features');
        $this->click('show-feature-' . $feature->id);
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
        $features = factory(Feature::class, 5)->create(['project_id' => $project->id, 'type_id' => 1]);
        $this->assertEquals(5, $features->count());

        $this->visit('projects/' . $project->id . '/features');
        $this->see($features[1]->name);
        $this->see(formatRp($features[1]->price));
    }

    /** @test */
    public function admin_may_clone_many_features_from_other_projects()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $projects = factory(Project::class, 2)->create(['owner_id' => $user->id]);
        $features = factory(Feature::class, 3)->create(['project_id' => $projects[0]->id]);
        $tasks1 = factory(Task::class, 3)->create(['feature_id' => $features[0]->id]);
        $tasks2 = factory(Task::class, 3)->create(['feature_id' => $features[1]->id]);

        $this->visit('projects/' . $projects[1]->id . '/features');
        $this->seePageIs('projects/' . $projects[1]->id . '/features');
        $this->click(trans('feature.add_from_other_project'));
        $this->seePageIs('projects/' . $projects[1]->id . '/features/add-from-other-project');
        $this->select($projects[0]->id, 'project_id');
        $this->press('Lihat Fitur');
        $this->seePageIs('projects/' . $projects[1]->id . '/features/add-from-other-project?project_id=' . $projects[0]->id);

        // $this->submitForm(trans('feature.create'), [
        //     'feature_ids' => [$features[0]->id,$features[1]->id],
        //     $features[0]->id . '_task_ids' => [$tasks1[0]->id,$tasks1[1]->id,$tasks1[2]->id],
        //     $features[1]->id . '_task_ids' => [$tasks2[0]->id,$tasks2[1]->id,$tasks2[2]->id],
        // ]);

        // $this->check('feature_ids[0]');
        // $this->check('feature_ids[1]');
        // $this->check($features[0]->id . '_task_ids[0]');
        // $this->check($features[0]->id . '_task_ids[1]');
        // $this->check($features[0]->id . '_task_ids[2]');
        // $this->check($features[1]->id . '_task_ids[0]');
        // $this->check($features[1]->id . '_task_ids[1]');
        // $this->check($features[1]->id . '_task_ids[2]');
        // $this->press(trans('feature.create'));

        $form = $this->getForm(trans('feature.create'));
        $form['feature_ids'][$features[0]->id]->tick();
        $form['feature_ids'][$features[1]->id]->tick();
        $form[$features[0]->id . '_task_ids'][$tasks1[0]->id]->tick();
        $form[$features[0]->id . '_task_ids'][$tasks1[1]->id]->tick();
        $form[$features[0]->id . '_task_ids'][$tasks1[2]->id]->tick();
        $form[$features[1]->id . '_task_ids'][$tasks2[0]->id]->tick();
        $form[$features[1]->id . '_task_ids'][$tasks2[1]->id]->tick();
        $form[$features[1]->id . '_task_ids'][$tasks2[2]->id]->tick();
        $this->makeRequestUsingForm($form);

        $this->seePageIs('projects/' . $projects[1]->id . '/features');
        $this->see(trans('feature.created_from_other_project'));
        $this->seeInDatabase('features', [
            'project_id' => $projects[1]->id,
            'name' => $features[0]->name,
            'price' => $features[0]->price,
            'worker_id' => $features[0]->worker_id,
        ]);
        $this->seeInDatabase('features', [
            'project_id' => $projects[1]->id,
            'name' => $features[1]->name,
            'price' => $features[1]->price,
            'worker_id' => $features[1]->worker_id,
        ]);
        // $this->seeInDatabase('tasks', [
        //     'feature_id' => $features[1]->id,
        //     'name' => $tasks1[0]->name,
        //     'price' => $features[1]->price,
        //     'worker_id' => $features[1]->worker_id,
        // ]);
    }

    /** @test */
    public function admin_can_see_unfinished_features_list()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        // $projects = factory(Project::class, 2)->create(['owner_id' => $user->id]);
        // $features = factory(Feature::class, 3)->create(['project_id'=> array_rand($projects->lists('id','id')->all())]);
        // $tasks = factory(Task::class, 10)->create(['feature_id'=> array_rand($features->lists('id','id')->all())]);

        $this->visit('features');
        $this->seePageIs('features');

    }
}

<?php

namespace Tests\Feature;

use App\Entities\Agencies\Agency;
use App\Entities\Partners\Customer;
use App\Entities\Projects\Feature;
use App\Entities\Projects\Project;
use App\Entities\Projects\Task;
use App\Entities\Users\User;
use Tests\TestCase;

class ManageFeaturesTest extends TestCase
{
    /** @test */
    public function admin_can_entry_feature()
    {
        $user = $this->adminUserSigningIn();

        $customer = factory(Customer::class)->create(['owner_id' => $user->agency->id]);
        $project  = factory(Project::class)->create(['owner_id' => $user->agency->id, 'customer_id' => $customer->id]);

        $worker = $this->createUser();

        $this->visit(route('projects.features', $project->id));
        $this->click(trans('feature.create'));
        $this->seePageIs(route('features.create', $project->id));

        $this->submitForm(trans('feature.create'), [
            'name'        => 'Nama Fitur Baru',
            'price'       => 100000,
            'worker_id'   => $worker->id,
            'type_id'     => 1,
            'description' => 'Similique, eligendi fuga animi?',
        ]);

        $this->see(trans('feature.created'));

        $this->seeInDatabase('features', [
            'name'       => 'Nama Fitur Baru',
            'price'      => 100000,
            'worker_id'  => $worker->id,
            'type_id'    => 1,
            'project_id' => $project->id,
        ]);
    }

    /** @test */
    public function admin_can_edit_feature_data()
    {
        $user   = factory(User::class, 3)->create();
        $agency = factory(Agency::class)->create(['owner_id' => $user[0]->id]);
        $this->actingAs($user[0]);

        $customer = factory(Customer::class)->create(['owner_id' => $agency->id]);
        $project  = factory(Project::class)->create(['owner_id' => $agency->id, 'customer_id' => $customer->id]);

        $feature = factory(Feature::class)->create(['worker_id' => $user[1]->id, 'project_id' => $project->id]);

        $this->visit(route('features.edit', $feature->id));

        $this->submitForm(trans('feature.update'), [
            'name'      => 'Nama Fitur Edit',
            'price'     => 33333,
            'worker_id' => $user[2]->id,
            'type_id'   => 2,
        ]);

        $this->seePageIs(route('features.show', $feature->id));

        $this->see(trans('feature.updated'));

        $this->seeInDatabase('features', [
            'name'       => 'Nama Fitur Edit',
            'price'      => 33333,
            'worker_id'  => $user[2]->id,
            'project_id' => $project->id,
            'type_id'    => 2,
        ]);
    }

    /** @test */
    public function admin_can_delete_a_feature()
    {
        $user     = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create(['owner_id' => $user->agency->id]);
        $project  = factory(Project::class)->create(['owner_id' => $user->agency->id, 'customer_id' => $customer->id]);
        $feature  = factory(Feature::class)->create(['project_id' => $project->id]);
        $tasks    = factory(Task::class, 2)->create(['feature_id' => $feature->id]);

        $this->seeInDatabase('features', [
            'name'       => $feature->name,
            'price'      => $feature->price,
            'project_id' => $project->id,
        ]);

        $this->visit(route('features.show', $feature->id));

        $this->click(trans('app.edit'));
        $this->click(trans('feature.delete'));
        $this->press(trans('app.delete_confirm_button'));

        $this->seePageIs(route('projects.features', $project->id));

        $this->see(trans('feature.deleted'));

        $this->notSeeInDatabase('features', [
            'name'       => $feature->name,
            'price'      => $feature->price,
            'project_id' => $project->id,
        ]);

        $this->notSeeInDatabase('tasks', [
            'feature_id' => $feature->id,
        ]);
    }

    /** @test */
    public function admin_can_see_a_feature()
    {
        $user = $this->adminUserSigningIn();

        $project = factory(Project::class)->create(['owner_id' => $user->id]);
        $feature = factory(Feature::class)->create(['project_id' => $project->id, 'type_id' => 1]);

        $this->visit(route('projects.features', $project->id));
        $this->click('show-feature-'.$feature->id);
        $this->seePageIs(route('features.show', $project->id));
        $this->see(trans('feature.show'));
        $this->see($feature->name);
        $this->see(formatRp($feature->price));
        $this->see($feature->worker->name);
    }

    /** @test */
    public function admin_may_clone_many_features_from_other_projects()
    {
        $user     = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create(['owner_id' => $user->agency->id]);
        $projects = factory(Project::class, 2)->create(['owner_id' => $user->agency->id, 'customer_id' => $customer->id]);
        $features = factory(Feature::class, 3)->create(['project_id' => $projects[0]->id]);
        $tasks1   = factory(Task::class, 3)->create(['feature_id' => $features[0]->id]);
        $tasks2   = factory(Task::class, 3)->create(['feature_id' => $features[1]->id]);

        $this->visit(route('projects.features', $projects[1]->id));

        $this->click(trans('feature.add_from_other_project'));
        $this->seePageIs(route('features.add-from-other-project', $projects[1]->id));

        $this->select($projects[0]->id, 'project_id');
        $this->press(trans('project.show_features'));
        $this->seePageIs(route('features.add-from-other-project', [$projects[1]->id, 'project_id' => $projects[0]->id]));

        $form = $this->getForm(trans('feature.create'));
        $form['feature_ids'][$features[0]->id]->tick();
        $form['feature_ids'][$features[1]->id]->tick();
        $form[$features[0]->id.'_task_ids'][$tasks1[0]->id]->tick();
        $form[$features[0]->id.'_task_ids'][$tasks1[1]->id]->tick();
        $form[$features[0]->id.'_task_ids'][$tasks1[2]->id]->tick();
        $form[$features[1]->id.'_task_ids'][$tasks2[0]->id]->tick();
        $form[$features[1]->id.'_task_ids'][$tasks2[1]->id]->tick();
        $form[$features[1]->id.'_task_ids'][$tasks2[2]->id]->tick();
        $this->makeRequestUsingForm($form);

        $this->seePageIs(route('projects.features', $projects[1]->id));

        $this->see(trans('feature.created_from_other_project'));

        $this->seeInDatabase('features', [
            'project_id' => $projects[1]->id,
            'name'       => $features[0]->name,
            'price'      => $features[0]->price,
            'worker_id'  => $features[0]->worker_id,
        ]);

        $this->seeInDatabase('features', [
            'project_id' => $projects[1]->id,
            'name'       => $features[1]->name,
            'price'      => $features[1]->price,
            'worker_id'  => $features[1]->worker_id,
        ]);
    }

    /** @test */
    public function admin_can_see_unfinished_features_list()
    {
        $user = $this->adminUserSigningIn();

        $this->visit(route('features.index'));
        $this->seePageIs(route('features.index'));
    }
}

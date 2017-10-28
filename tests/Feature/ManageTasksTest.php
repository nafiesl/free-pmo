<?php

namespace Tests\Feature;

use App\Entities\Projects\Feature;
use App\Entities\Projects\Project;
use App\Entities\Projects\Task;
use Tests\TestCase;

class ManageTasksTest extends TestCase
{
    /** @test */
    public function admin_can_entry_task()
    {
        $user    = $this->adminUserSigningIn();
        $project = factory(Project::class)->create(['owner_id' => $user->agency->id]);

        $feature = factory(Feature::class)->create(['worker_id' => $user->id, 'project_id' => $project->id]);
        $this->visit('features/'.$feature->id);
        $this->seePageIs('features/'.$feature->id);
        $this->see(trans('feature.tasks'));
        $this->see(trans('task.create'));

        // Fill Form
        $this->type('Nama Task Baru', 'name');
        $this->type('Ipsam magnam laboriosam distinctio officia facere sapiente eius corporis', 'description');
        $this->type(70, 'progress');
        $this->type('tasks/create', 'route_name');
        $this->press(trans('task.create'));

        $this->seePageIs('features/'.$feature->id);
        $this->see(trans('task.created'));
        $this->seeInDatabase('tasks', [
            'name'       => 'Nama Task Baru',
            'progress'   => 70,
            'feature_id' => $feature->id,
            'route_name' => 'tasks/create',
        ]);
    }

    /** @test */
    public function admin_can_edit_task_data()
    {
        $user    = $this->adminUserSigningIn();
        $project = factory(Project::class)->create(['owner_id' => $user->agency->id]);

        $feature = factory(Feature::class)->create(['worker_id' => $user->id, 'project_id' => $project->id]);

        $task = factory(Task::class)->create(['feature_id' => $feature->id]);

        $this->visit('features/'.$feature->id);
        $this->click($task->id.'-tasks-edit');
        $this->seePageIs('features/'.$feature->id.'?action=task_edit&task_id='.$task->id);
        $this->see(trans('task.edit'));
        $this->see(trans('task.update'));

        // Fill Form
        $this->type('Nama Task Edit', 'name');
        $this->type(77, 'progress');
        $this->press(trans('task.update'));

        $this->seePageIs('features/'.$feature->id);
        $this->see(trans('task.updated'));
        $this->seeInDatabase('tasks', [
            'name'       => 'Nama Task Edit',
            'progress'   => 77,
            'feature_id' => $feature->id,
        ]);
    }

    /** @test */
    public function admin_can_delete_a_task()
    {
        $user    = $this->adminUserSigningIn();
        $project = factory(Project::class)->create(['owner_id' => $user->agency->id]);

        $feature = factory(Feature::class)->create(['worker_id' => $user->id, 'project_id' => $project->id]);

        $task = factory(Task::class)->create(['feature_id' => $feature->id]);

        $this->visit('features/'.$feature->id);
        $this->click($task->id.'-tasks-delete');
        $this->see(trans('app.delete_confirm_button'));
        $this->press(trans('app.delete_confirm_button'));
        $this->seePageIs('features/'.$feature->id);
        $this->see(trans('task.deleted'));
    }
}

<?php

namespace Tests\Feature;

use App\Entities\Projects\Feature;
use App\Entities\Projects\Task;
use Tests\TestCase;

class ManageTasksTest extends TestCase
{
    /** @test */
    public function admin_can_entry_task()
    {
        $user    = $this->adminUserSigningIn();
        $feature = factory(Feature::class)->create(['worker_id' => $user->id]);

        $this->visit(route('features.show', $feature->id));
        $this->seePageIs(route('features.show', $feature->id));
        $this->see(trans('feature.tasks'));

        // Fill Form
        $this->submitForm(trans('task.create'), [
            'name'        => 'Nama Task Baru',
            'description' => 'Deskripsi task yang dikerjakani.',
            'progress'    => 70,
            'route_name'  => 'tasks/create',
        ]);

        $this->seePageIs(route('features.show', $feature->id));
        $this->see(trans('task.created'));

        $this->seeInDatabase('tasks', [
            'name'        => 'Nama Task Baru',
            'description' => 'Deskripsi task yang dikerjakani.',
            'progress'    => 70,
            'feature_id'  => $feature->id,
            'route_name'  => 'tasks/create',
        ]);
    }

    /** @test */
    public function admin_can_edit_task_data()
    {
        $user    = $this->adminUserSigningIn();
        $feature = factory(Feature::class)->create(['worker_id' => $user->id]);
        $task    = factory(Task::class)->create(['feature_id' => $feature->id]);

        $this->visit(route('features.show', $feature->id));
        $this->click($task->id.'-tasks-edit');
        $this->seePageIs(route('features.show', [$feature->id, 'action' => 'task_edit', 'task_id' => $task->id]));
        $this->see(trans('task.edit'));

        // Fill Form
        $this->submitForm(trans('task.update'), [
            'name'     => 'Nama Task Edit',
            'progress' => 77,
        ]);

        $this->seePageIs(route('features.show', $feature->id));
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
        $feature = factory(Feature::class)->create(['worker_id' => $user->id]);
        $task    = factory(Task::class)->create(['feature_id' => $feature->id]);

        $this->visit(route('features.show', $feature->id));
        $this->click($task->id.'-tasks-delete');
        $this->see(trans('app.delete_confirm_button'));
        $this->press(trans('app.delete_confirm_button'));

        $this->seePageIs(route('features.show', $feature->id));
        $this->see(trans('task.deleted'));
    }
}

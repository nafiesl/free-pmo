<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Entities\Projects\Job;
use App\Entities\Projects\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_entry_task()
    {
        $user = $this->adminUserSigningIn();
        $job = factory(Job::class)->create(['worker_id' => $user->id]);

        $this->visit(route('jobs.show', $job->id));
        $this->seePageIs(route('jobs.show', $job->id));
        $this->see(trans('job.tasks'));

        // Fill Form
        $this->submitForm(trans('task.create'), [
            'name'        => 'Nama Task Baru',
            'description' => 'Deskripsi task yang dikerjakani.',
            'progress'    => 70,
        ]);

        $this->seePageIs(route('jobs.show', $job->id));
        $this->see(trans('task.created'));

        $this->seeInDatabase('tasks', [
            'name'        => 'Nama Task Baru',
            'description' => 'Deskripsi task yang dikerjakani.',
            'progress'    => 70,
            'job_id'      => $job->id,
        ]);
    }

    /** @test */
    public function admin_can_edit_task_data()
    {
        $user = $this->adminUserSigningIn();
        $job = factory(Job::class)->create(['worker_id' => $user->id]);
        $task = factory(Task::class)->create(['job_id' => $job->id]);

        $this->visit(route('jobs.show', $job->id));
        $this->click($task->id.'-tasks-edit');
        $this->seePageIs(route('jobs.show', [$job->id, 'action' => 'task_edit', 'task_id' => $task->id]));
        $this->see(trans('task.edit'));

        // Fill Form
        $this->submitForm(trans('task.update'), [
            'name'     => 'Nama Task Edit',
            'progress' => 77,
        ]);

        $this->seePageIs(route('jobs.show', $job->id));
        $this->see(trans('task.updated'));

        $this->seeInDatabase('tasks', [
            'name'     => 'Nama Task Edit',
            'progress' => 77,
            'job_id'   => $job->id,
        ]);
    }

    /** @test */
    public function admin_can_delete_a_task()
    {
        $user = $this->adminUserSigningIn();
        $job = factory(Job::class)->create(['worker_id' => $user->id]);
        $task = factory(Task::class)->create(['job_id' => $job->id]);

        $this->visit(route('jobs.show', $job->id));
        $this->click($task->id.'-tasks-delete');
        $this->see(trans('app.delete_confirm_button'));
        $this->press(trans('app.delete_confirm_button'));

        $this->seePageIs(route('jobs.show', $job->id));
        $this->see(trans('task.deleted'));
    }
}

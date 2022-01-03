<?php

namespace Tests\Feature;

use App\Entities\Projects\Job;
use App\Entities\Projects\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
        $this->see(__('job.tasks'));

        // Fill Form
        $this->submitForm(__('task.create'), [
            'name' => 'Nama Task Baru',
            'description' => 'Deskripsi task yang dikerjakani.',
            'progress' => 70,
        ]);

        $this->seePageIs(route('jobs.show', $job->id));
        $this->see(__('task.created'));

        $this->seeInDatabase('tasks', [
            'name' => 'Nama Task Baru',
            'description' => 'Deskripsi task yang dikerjakani.',
            'progress' => 70,
            'job_id' => $job->id,
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
        $this->see(__('task.edit'));

        // Fill Form
        $this->submitForm(__('task.update'), [
            'name' => 'Nama Task Edit',
            'progress' => 77,
        ]);

        $this->seePageIs(route('jobs.show', $job->id));
        $this->see(__('task.updated'));

        $this->seeInDatabase('tasks', [
            'name' => 'Nama Task Edit',
            'progress' => 77,
            'job_id' => $job->id,
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
        $this->see(__('app.delete_confirm_button'));
        $this->press(__('app.delete_confirm_button'));

        $this->seePageIs(route('jobs.show', $job->id));
        $this->see(__('task.deleted'));
    }

    /** @test */
    public function admin_can_set_a_task_as_done()
    {
        $user = $this->adminUserSigningIn();
        $job = factory(Job::class)->create(['worker_id' => $user->id]);
        $task = factory(Task::class)->create(['job_id' => $job->id, 'progress' => 0]);

        $this->visit(route('jobs.show', $job->id));
        $this->press($task->id.'-set_task_done');

        $this->seePageIs(route('jobs.show', $job->id));
        $this->see(__('task.updated'));
        $this->dontSeeElement('button', ['id' => $task->id.'-set_task_done']);
        $this->seeInDatabase('tasks', [
            'id' => $task->id,
            'progress' => 100,
        ]);
    }
}

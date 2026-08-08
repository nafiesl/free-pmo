<?php

namespace Tests\Feature\Api;

use App\Entities\Projects\Job;
use App\Entities\Projects\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_task()
    {
        $user = $this->createUser('admin');
        $job = factory(Job::class)->create();

        $this->postJson(route('api.tasks.store'), [
            'job_id' => $job->id,
            'name' => 'Buat endpoint POST /manifests/create',
            'progress' => 0,
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(201);
        $this->seeJson(['message' => __('task.created')]);
        $this->seeInDatabase('tasks', ['name' => 'Buat endpoint POST /manifests/create']);
    }

    /** @test */
    public function admin_can_update_task_progress()
    {
        $user = $this->createUser('admin');
        $job = factory(Job::class)->create();
        $task = factory(Task::class)->create(['job_id' => $job->id, 'progress' => 0]);

        $this->patchJson(route('api.tasks.update', $task), [
            'progress' => 75,
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('task.updated'), 'progress' => 75]);
        $this->seeInDatabase('tasks', ['id' => $task->id, 'progress' => 75]);
    }

    /** @test */
    public function worker_cannot_update_task_of_other_worker()
    {
        $user = $this->createUser('worker');
        $otherWorker = $this->createUser('worker');
        $job = factory(Job::class)->create(['worker_id' => $otherWorker->id]);
        $task = factory(Task::class)->create(['job_id' => $job->id, 'progress' => 0]);

        $this->patchJson(route('api.tasks.update', $task), [
            'progress' => 50,
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(403);
    }

    /** @test */
    public function admin_can_delete_task()
    {
        $user = $this->createUser('admin');
        $job = factory(Job::class)->create();
        $task = factory(Task::class)->create(['job_id' => $job->id]);

        $this->deleteJson(route('api.tasks.destroy', $task), [], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('task.deleted')]);
        $this->dontSeeInDatabase('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function worker_cannot_delete_task()
    {
        $user = $this->createUser('worker');
        $task = factory(Task::class)->create();

        $this->deleteJson(route('api.tasks.destroy', $task), [], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(403);
    }
}

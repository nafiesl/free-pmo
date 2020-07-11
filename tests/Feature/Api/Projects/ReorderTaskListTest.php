<?php

namespace Tests\Feature\Api\Projects;

use App\Entities\Projects\Project;
use App\Entities\Projects\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReorderTaskListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_reorder_task_position()
    {
        $admin = $this->adminUserSigningIn();
        $job = factory(Project::class)->create();
        $task1 = factory(Task::class)->create(['job_id' => $job->id, 'position' => 1]);
        $task2 = factory(Task::class)->create(['job_id' => $job->id, 'position' => 2]);

        $this->postJson(route('jobs.tasks-reorder', $job), [
            'postData' => $task2->id.','.$task1->id,
        ]);

        $this->seeInDatabase('tasks', [
            'id'       => $task1->id,
            'position' => 2,
        ]);

        $this->seeInDatabase('tasks', [
            'id'       => $task2->id,
            'position' => 1,
        ]);
    }
}

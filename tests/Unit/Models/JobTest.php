<?php

namespace Tests\Unit\Models;

use App\Entities\Projects\Job;
use App\Entities\Projects\Project;
use App\Entities\Projects\Task;
use Illuminate\Support\Collection;
use Tests\TestCase;

/**
 * Job Model Unit Test.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class JobTest extends TestCase
{
    /** @test */
    public function a_job_belongs_to_a_project()
    {
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create(['project_id' => $project->id]);

        $this->assertInstanceOf(Project::class, $job->project);
        $this->assertEquals($project->id, $job->project->id);
    }

    /** @test */
    public function a_job_has_many_tasks()
    {
        $job = factory(Job::class)->create();
        $tasks = factory(Task::class, 2)->create(['job_id' => $job->id]);

        $this->assertInstanceOf(Collection::class, $job->tasks);
        $this->assertInstanceOf(Task::class, $job->tasks->first());
    }

    /** @test */
    public function a_job_has_progress_attribute()
    {
        $job = factory(Job::class)->create();
        $task1 = factory(Task::class)->create(['job_id' => $job->id, 'progress' => 100]);
        $task2 = factory(Task::class)->create(['job_id' => $job->id, 'progress' => 50]);

        // Job progress = job tasks average progress
        $this->assertEquals(75, $job->progress);
    }

    /** @test */
    public function a_job_has_receiveable_earning_attribute()
    {
        $job = factory(Job::class)->create(['price' => 1000]);
        $task1 = factory(Task::class)->create(['job_id' => $job->id, 'progress' => 100]);
        $task2 = factory(Task::class)->create(['job_id' => $job->id, 'progress' => 50]);

        // Job receiveable earning = job tasks average progress (%) * job price
        $this->assertEquals(750, $job->receiveable_earning);
    }
}

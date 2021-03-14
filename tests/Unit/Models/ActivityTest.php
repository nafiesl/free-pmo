<?php

namespace Tests\Unit\Models;

use App\Entities\Projects\Job;
use App\Entities\Projects\Project;
use App\Entities\Projects\Task;
use App\Entities\Users\Activity;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_project_creation_activities()
    {
        $admin = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();

        $this->seeInDatabase('user_activities', [
            'type'        => 'project_created',
            'parent_id'   => null,
            'user_id'     => $admin->id,
            'object_id'   => $project->id,
            'object_type' => 'projects',
            'data'        => null,
        ]);
    }

    /** @test */
    public function it_records_project_data_update_activities()
    {
        $admin = $this->adminUserSigningIn();
        $project = factory(Project::class)->create(['name' => 'New Project']);

        $project->name = 'Updated project';
        $project->save();

        $this->seeInDatabase('user_activities', [
            'type'        => 'project_updated',
            'parent_id'   => null,
            'user_id'     => $admin->id,
            'object_id'   => $project->id,
            'object_type' => 'projects',
            'data'        => json_encode([
                'before' => ['name' => 'New Project'],
                'after'  => ['name' => 'Updated project'],
                'notes'  => null,
            ]),
        ]);
    }

    /** @test */
    public function it_records_job_creation_activities()
    {
        $admin = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create(['project_id' => $project->id]);

        $this->seeInDatabase('user_activities', [
            'type'        => 'job_created',
            'parent_id'   => null,
            'user_id'     => $admin->id,
            'object_id'   => $job->id,
            'object_type' => 'jobs',
            'data'        => null,
        ]);
    }

    /** @test */
    public function it_records_job_data_update_activities()
    {
        $admin = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create([
            'name'       => 'New Job',
            'project_id' => $project->id,
        ]);

        $job->name = 'Updated job';
        $job->save();

        $this->seeInDatabase('user_activities', [
            'type'        => 'job_updated',
            'parent_id'   => null,
            'user_id'     => $admin->id,
            'object_id'   => $job->id,
            'object_type' => 'jobs',
            'data'        => json_encode([
                'before' => ['name' => 'New Job'],
                'after'  => ['name' => 'Updated job'],
                'notes'  => null,
            ]),
        ]);
    }

    /** @test */
    public function it_records_job_deletion_activities()
    {
        $admin = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create(['project_id' => $project->id]);
        $job->delete();

        $this->seeInDatabase('user_activities', [
            'type'        => 'job_deleted',
            'parent_id'   => null,
            'user_id'     => $admin->id,
            'object_id'   => $project->id,
            'object_type' => 'projects',
            'data'        => json_encode([
                'name'        => $job->name,
                'description' => $job->description,
                'price'       => $job->price,
            ]),
        ]);
    }

    /** @test */
    public function it_records_task_creation_activities()
    {
        $admin = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create(['project_id' => $project->id]);
        $task = factory(Task::class)->create(['job_id' => $job->id]);

        $this->seeInDatabase('user_activities', [
            'type'        => 'task_created',
            'parent_id'   => null,
            'user_id'     => $admin->id,
            'object_id'   => $task->id,
            'object_type' => 'tasks',
            'data'        => null,
        ]);
    }

    /** @test */
    public function it_records_task_data_update_activities()
    {
        $admin = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create(['project_id' => $project->id]);
        $task = factory(Task::class)->create([
            'name'   => 'New Task',
            'job_id' => $job->id,
        ]);

        $task->name = 'Updated task';
        $task->save();

        $this->seeInDatabase('user_activities', [
            'type'        => 'task_updated',
            'parent_id'   => null,
            'user_id'     => $admin->id,
            'object_id'   => $task->id,
            'object_type' => 'tasks',
            'data'        => json_encode([
                'before' => ['name' => 'New Task'],
                'after'  => ['name' => 'Updated task'],
                'notes'  => null,
            ]),
        ]);
    }

    /** @test */
    public function it_records_task_progress_update_activities()
    {
        $admin = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create(['project_id' => $project->id]);
        $task = factory(Task::class)->create([
            'progress' => 20,
            'job_id'   => $job->id,
        ]);

        $task->progress = 40;
        $task->save();

        $this->seeInDatabase('user_activities', [
            'type'        => 'task_updated',
            'parent_id'   => null,
            'user_id'     => $admin->id,
            'object_id'   => $task->id,
            'object_type' => 'tasks',
            'data'        => json_encode([
                'before' => ['progress' => 20],
                'after'  => ['progress' => 40],
                'notes'  => null,
            ]),
        ]);
    }

    /** @test */
    public function it_records_task_deletion_activities()
    {
        $admin = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create(['project_id' => $project->id]);
        $task = factory(Task::class)->create(['job_id' => $job->id]);
        $task->delete();

        $this->seeInDatabase('user_activities', [
            'type'        => 'task_deleted',
            'parent_id'   => null,
            'user_id'     => $admin->id,
            'object_id'   => $job->id,
            'object_type' => 'jobs',
            'data'        => json_encode([
                'name'        => $task->name,
                'description' => $task->description,
                'progress'    => $task->progress,
            ]),
        ]);
    }

    /** @test */
    public function an_activity_has_belongs_to_user_relation()
    {
        $project = factory(Project::class)->create();
        $activity = Activity::where('object_type', 'projects')
            ->where('object_id', $project->id)
            ->first();

        $this->assertInstanceOf(User::class, $activity->user);
        $this->assertEquals($activity->user_id, $activity->user->id);
    }

    /** @test */
    public function an_activity_has_belongs_to_object_relation()
    {
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create(['project_id' => $project->id]);
        $task = factory(Task::class)->create(['job_id' => $job->id]);

        $projectActivity = Activity::where('object_type', 'projects')->first();
        $this->assertInstanceOf(Project::class, $projectActivity->object);
        $this->assertEquals($projectActivity->object_id, $projectActivity->object->id);

        $jobActivity = Activity::where('object_type', 'jobs')->first();
        $this->assertInstanceOf(Job::class, $jobActivity->object);
        $this->assertEquals($jobActivity->object_id, $jobActivity->object->id);

        $taskActivity = Activity::where('object_type', 'tasks')->first();
        $this->assertInstanceOf(Task::class, $taskActivity->object);
        $this->assertEquals($taskActivity->object_id, $taskActivity->object->id);
    }
}

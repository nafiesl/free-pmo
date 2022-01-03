<?php

namespace Tests\Feature;

use App\Entities\Partners\Customer;
use App\Entities\Projects\Job;
use App\Entities\Projects\Project;
use App\Entities\Projects\Task;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Manage Project Feature Test.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class ManageJobsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_entry_job()
    {
        $user = $this->adminUserSigningIn();

        $customer = factory(Customer::class)->create();
        $project = factory(Project::class)->create(['customer_id' => $customer->id]);

        $worker = $this->createUser();

        $this->visit(route('projects.jobs.index', $project->id));
        $this->click(__('job.create'));
        $this->seePageIs(route('projects.jobs.create', $project->id));

        $this->submitForm(__('job.create'), [
            'name' => 'Nama Fitur Baru',
            'price' => 100000,
            'worker_id' => $worker->id,
            'type_id' => 1,
            'target_start_date' => '2017-04-04',
            'target_end_date' => '2017-07-07',
            'description' => 'Similique, eligendi fuga animi?',
        ]);

        $this->see(__('job.created'));

        $this->seeInDatabase('jobs', [
            'name' => 'Nama Fitur Baru',
            'price' => 100000,
            'worker_id' => $worker->id,
            'type_id' => 1,
            'project_id' => $project->id,
            'target_start_date' => '2017-04-04',
            'target_end_date' => '2017-07-07',
        ]);
    }

    /** @test */
    public function admin_can_edit_job_data()
    {
        $users = factory(User::class, 3)->create();
        $users[0]->assignRole('admin');
        $this->actingAs($users[0]);

        $customer = factory(Customer::class)->create();
        $project = factory(Project::class)->create(['customer_id' => $customer->id]);

        $job = factory(Job::class)->create(['worker_id' => $users[1]->id, 'project_id' => $project->id]);

        $this->visit(route('jobs.edit', $job->id));

        $this->submitForm(__('job.update'), [
            'name' => 'Nama Fitur Edit',
            'price' => 33333,
            'worker_id' => $users[2]->id,
            'type_id' => 2,
            'target_start_date' => '2017-04-04',
            'target_end_date' => '2017-07-07',
            'actual_start_date' => '2017-04-04',
            'actual_end_date' => '2017-07-07',
        ]);

        $this->seePageIs(route('jobs.show', $job->id));

        $this->see(__('job.updated'));

        $this->seeInDatabase('jobs', [
            'name' => 'Nama Fitur Edit',
            'price' => 33333,
            'worker_id' => $users[2]->id,
            'project_id' => $project->id,
            'type_id' => 2,
            'target_start_date' => '2017-04-04',
            'target_end_date' => '2017-07-07',
            'actual_start_date' => '2017-04-04',
            'actual_end_date' => '2017-07-07',
        ]);
    }

    /** @test */
    public function admin_can_delete_a_job()
    {
        $this->adminUserSigningIn();

        $job = factory(Job::class)->create();
        $tasks = factory(Task::class, 2)->create(['job_id' => $job->id]);

        $this->seeInDatabase('jobs', [
            'id' => $job->id,
        ]);

        $this->visit(route('jobs.show', $job));

        $this->click(__('app.edit'));
        $this->click(__('job.delete'));
        $this->press(__('app.delete_confirm_button'));

        $this->seePageIs(route('projects.jobs.index', $job->project_id));

        $this->see(__('job.deleted'));

        $this->notSeeInDatabase('jobs', [
            'id' => $job->id,
        ]);

        $this->notSeeInDatabase('tasks', [
            'job_id' => $job->id,
        ]);
    }

    /** @test */
    public function admin_can_see_a_job()
    {
        $user = $this->adminUserSigningIn();

        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 1]);

        $this->visit(route('projects.jobs.index', $project->id));
        $this->click('show-job-'.$job->id);
        $this->seePageIs(route('jobs.show', $project->id));
        $this->see(__('job.detail'));
        $this->see($job->name);
        $this->see(format_money($job->price));
        $this->see($job->worker->name);
    }

    /** @test */
    public function admin_may_clone_many_jobs_from_other_projects()
    {
        $user = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create();
        $projects = factory(Project::class, 2)->create(['customer_id' => $customer->id]);
        $jobs = factory(Job::class, 3)->create(['project_id' => $projects[0]->id]);
        $tasks1 = factory(Task::class, 3)->create(['job_id' => $jobs[0]->id]);
        $tasks2 = factory(Task::class, 3)->create(['job_id' => $jobs[1]->id]);

        $this->visit(route('projects.jobs.index', $projects[1]->id));

        $this->click(__('job.add_from_other_project'));
        $this->seePageIs(route('projects.jobs.add-from-other-project', $projects[1]->id));

        $this->select($projects[0]->id, 'project_id');
        $this->press(__('project.show_jobs'));
        $this->seePageIs(route('projects.jobs.add-from-other-project', [$projects[1]->id, 'project_id' => $projects[0]->id]));

        $this->submitForm(__('job.add'), [
            'job_ids['.$jobs[0]->id.']' => $jobs[0]->id,

            $jobs[0]->id.'_task_ids['.$tasks1[0]->id.']' => $tasks1[0]->id,
            $jobs[0]->id.'_task_ids['.$tasks1[1]->id.']' => $tasks1[1]->id,
            $jobs[0]->id.'_task_ids['.$tasks1[2]->id.']' => $tasks1[2]->id,

            'job_ids['.$jobs[1]->id.']' => $jobs[1]->id,

            $jobs[1]->id.'_task_ids['.$tasks2[0]->id.']' => $tasks2[0]->id,
            $jobs[1]->id.'_task_ids['.$tasks2[1]->id.']' => $tasks2[1]->id,
            $jobs[1]->id.'_task_ids['.$tasks2[2]->id.']' => $tasks2[2]->id,
        ]);

        $this->seePageIs(route('projects.jobs.index', $projects[1]->id));

        $this->see(__('job.created_from_other_project'));

        $this->seeInDatabase('jobs', [
            'project_id' => $projects[1]->id,
            'name' => $jobs[0]->name,
            'price' => $jobs[0]->price,
            'worker_id' => $jobs[0]->worker_id,
        ]);

        $this->seeInDatabase('jobs', [
            'project_id' => $projects[1]->id,
            'name' => $jobs[1]->name,
            'price' => $jobs[1]->price,
            'worker_id' => $jobs[1]->worker_id,
        ]);
    }

    /** @test */
    public function validate_clone_many_jobs_from_other_projects()
    {
        $user = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create();
        $projects = factory(Project::class, 2)->create(['customer_id' => $customer->id]);
        $jobs = factory(Job::class, 3)->create(['project_id' => $projects[0]->id]);
        $tasks1 = factory(Task::class, 3)->create(['job_id' => $jobs[0]->id]);
        $tasks2 = factory(Task::class, 3)->create(['job_id' => $jobs[1]->id]);

        $this->visit(route('projects.jobs.add-from-other-project', [$projects[1]->id, 'project_id' => $projects[0]->id]));

        $this->submitForm(__('job.add'), []);

        $this->seePageIs(route('projects.jobs.add-from-other-project', [$projects[1]->id, 'project_id' => $projects[0]->id]));
        $this->see(__('validation.select_one'));
    }

    /** @test */
    public function admin_can_see_unfinished_jobs_list()
    {
        $user = $this->adminUserSigningIn();

        $this->visit(route('jobs.index'));
        $this->seePageIs(route('jobs.index'));
    }

    /** @test */
    public function admin_can_upgrade_a_task_to_become_job()
    {
        $user = $this->adminUserSigningIn();

        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create([
            'project_id' => $project->id,
            'type_id' => 1,
            'worker_id' => $user->id,
        ]);
        $task = factory(Task::class)->create([
            'name' => 'This is a Task',
            'job_id' => $job->id,
            'description' => 'Task description.',
        ]);

        $this->visitRoute('jobs.show', [$job, 'action' => 'task_edit', 'task_id' => $task->id]);
        $this->seeRouteIs('jobs.show', [$job, 'action' => 'task_edit', 'task_id' => $task->id]);
        $this->seeElement('button', ['id' => 'set-as-job-'.$task->id]);

        $this->press('set-as-job-'.$task->id);

        $newJob = Job::where('name', 'This is a Task')->first();
        $this->seeRouteIs('jobs.edit', $newJob);

        $this->seeInDatabase('jobs', [
            'id' => $newJob->id,
            'name' => 'This is a Task',
            'description' => 'Task description.',
        ]);
        $this->dontSeeInDatabase('tasks', [
            'id' => $task->id,
        ]);
    }

    /** @test */
    public function admin_can_clone_jobs_without_tasks()
    {
        $user = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create();
        $projects = factory(Project::class, 2)->create(['customer_id' => $customer->id]);
        $jobs = factory(Job::class, 3)->create(['project_id' => $projects[0]->id]);
        $tasks1 = factory(Task::class, 3)->create(['job_id' => $jobs[0]->id]);
        $tasks2 = factory(Task::class, 3)->create(['job_id' => $jobs[1]->id]);

        $this->visitRoute('projects.jobs.add-from-other-project', [$projects[1]->id, 'project_id' => $projects[0]->id]);

        $this->submitForm(__('job.add'), [
            'job_ids['.$jobs[0]->id.']' => $jobs[0]->id,
            'job_ids['.$jobs[1]->id.']' => $jobs[1]->id,
        ]);

        $this->seeInDatabase('jobs', [
            'name' => $jobs[0]->name,
            'price' => $jobs[0]->price,
            'project_id' => $projects[1]->id,
            'worker_id' => $jobs[0]->worker_id,
        ]);

        $this->seeInDatabase('jobs', [
            'name' => $jobs[1]->name,
            'price' => $jobs[1]->price,
            'project_id' => $projects[1]->id,
            'worker_id' => $jobs[1]->worker_id,
        ]);
    }
}

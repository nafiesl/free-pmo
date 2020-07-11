<?php

namespace Tests\Feature;

use App\Entities\Partners\Customer;
use App\Entities\Payments\Payment;
use App\Entities\Projects\Job;
use App\Entities\Projects\Project;
use App\Entities\Projects\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_input_new_project_with_existing_customer()
    {
        $user = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create();

        $this->visit(route('projects.create'));

        $this->submitForm(__('project.create'), [
            'name'           => 'Project Baru',
            'customer_id'    => $customer->id,
            'proposal_date'  => '2016-04-15',
            'proposal_value' => '2000000',
            'description'    => 'Deskripsi project baru',
        ]);

        $this->see(__('project.created'));
        $this->see('Project Baru');
        $this->seeInDatabase('projects', [
            'name'           => 'Project Baru',
            'proposal_value' => '2000000',
        ]);
    }

    /** @test */
    public function admin_can_input_new_project_with_new_customer()
    {
        $user = $this->adminUserSigningIn();

        $this->visit(route('projects.create'));

        // Invalid entry
        $this->submitForm(__('project.create'), [
            'name'           => 'Project Baru',
            'customer_id'    => '',
            'proposal_date'  => '2016-04-15',
            'proposal_value' => '2000000',
            'description'    => 'Deskripsi project baru',
        ]);

        $this->seePageIs(route('projects.create'));

        $this->notSeeInDatabase('projects', [
            'name'           => 'Project Baru',
            'proposal_value' => '2000000',
        ]);

        $this->submitForm(__('project.create'), [
            'customer_name'  => 'Customer Baru',
            'customer_email' => 'email@customer.baru',
        ]);

        $this->see(__('project.created'));

        $this->seeInDatabase('customers', [
            'name'  => 'Customer Baru',
            'email' => 'email@customer.baru',
        ]);

        $newCustomer = Customer::whereName('Customer Baru')->whereEmail('email@customer.baru')->first();

        $this->seeInDatabase('projects', [
            'name'           => 'Project Baru',
            'proposal_value' => '2000000',
            'customer_id'    => $newCustomer->id,
        ]);
    }

    /** @test */
    public function admin_can_delete_a_project()
    {
        $this->adminUserSigningIn();

        $project = factory(Project::class)->create();
        $payment = factory(Payment::class)->create(['project_id' => $project->id]);
        $job = factory(Job::class)->create(['project_id' => $project->id]);
        $task = factory(Task::class)->create(['job_id' => $job->id]);

        $this->visit(route('projects.edit', $project));

        $this->click(__('app.delete'));
        $this->press(__('app.delete_confirm_button'));

        $this->seePageIs(route('projects.index'));
        $this->see(__('project.deleted'));

        $this->notSeeInDatabase('projects', [
            'name'           => $project->name,
            'proposal_value' => $project->proposal_value,
        ]);

        $this->notSeeInDatabase('payments', [
            'project_id' => $project->id,
        ]);

        $this->notSeeInDatabase('jobs', [
            'project_id' => $project->id,
        ]);

        $this->notSeeInDatabase('tasks', [
            'job_id' => $job->id,
        ]);
    }

    /** @test */
    public function admin_can_edit_a_project()
    {
        $user = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create();
        $project = factory(Project::class)->create([
            'customer_id' => $customer->id,
            'status_id'   => 2,
        ]);

        $this->visit(route('projects.edit', $project));
        $this->seePageIs(route('projects.edit', $project));

        $this->submitForm(__('project.update'), [
            'name'           => 'Edit Project',
            'proposal_date'  => '2016-04-15',
            'start_date'     => '2016-04-25',
            'end_date'       => '2016-05-05',
            'due_date'       => '2016-05-10',
            'proposal_value' => 2000000,
            'project_value'  => 2000000,
            'status_id'      => 4,
            'customer_id'    => $customer->id,
            'description'    => 'Edit deskripsi project',
        ]);

        $this->seePageIs(route('projects.edit', $project));
        $this->see(__('project.updated'));

        $this->seeInDatabase('projects', [
            'id'             => $project->id,
            'name'           => 'Edit Project',
            'proposal_date'  => '2016-04-15',
            'start_date'     => '2016-04-25',
            'end_date'       => '2016-05-05',
            'due_date'       => '2016-05-10',
            'proposal_value' => 2000000,
            'project_value'  => 2000000,
            'status_id'      => 4,
            'customer_id'    => $customer->id,
            'description'    => 'Edit deskripsi project',
        ]);
    }

    /** @test */
    public function form_is_validated_on_invalid_project_entry()
    {
        $user = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create();

        $this->visit(route('projects.index'));
        $this->seePageIs(route('projects.index'));

        $this->click(__('project.create'));
        $this->seePageIs(route('projects.create'));

        $this->press(__('project.create'), [
            'name'           => '',
            'customer_id'    => $customer->id,
            'proposal_date'  => '2016-04-15aa',
            'proposal_value' => '',
            'description'    => 'Deskripsi project baru',
        ]);

        $this->seePageIs(route('projects.create'));
        $this->see(__('validation.flash_message'));
    }

    /** @test */
    public function admin_can_change_project_status_on_project_detail_page()
    {
        $this->adminUserSigningIn();
        $project = factory(Project::class)->create(['status_id' => 1]);

        $this->visit(route('projects.show', $project->id));
        $this->seePageIs(route('projects.show', $project->id));

        $this->select(2, 'status_id');
        $this->press(__('project.update_status'));

        $this->see(__('project.updated'));
        $this->seePageIs(route('projects.show', $project->id));

        $this->seeInDatabase('projects', [
            'id'        => $project->id,
            'status_id' => 2,
        ]);
    }
}

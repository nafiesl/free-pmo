<?php

namespace Tests\Feature;

use App\Entities\Partners\Customer;
use App\Entities\Payments\Payment;
use App\Entities\Projects\Job;
use App\Entities\Projects\Project;
use App\Entities\Projects\Task;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    /** @test */
    public function admin_can_input_new_project_with_existing_customer()
    {
        $user = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create();

        $this->visit(route('projects.create'));

        $this->submitForm(trans('project.create'), [
            'name'           => 'Project Baru',
            'customer_id'    => $customer->id,
            'proposal_date'  => '2016-04-15',
            'proposal_value' => '2000000',
            'description'    => 'Deskripsi project baru',
        ]);

        $this->see(trans('project.created'));
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
        $this->submitForm(trans('project.create'), [
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

        $this->type('Customer Baru', 'customer_name');
        $this->type('email@customer.baru', 'customer_email');
        $this->press(trans('project.create'));

        $this->see(trans('project.created'));

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
        $user = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create();

        $project = factory(Project::class)->create(['customer_id' => $customer->id]);
        $job = factory(Job::class)->create(['project_id' => $project->id]);
        $task = factory(Task::class)->create(['job_id' => $job->id]);
        $payment = factory(Payment::class)->create(['project_id' => $project->id]);

        $this->visit('projects/'.$project->id);
        $this->click(trans('app.edit'));
        $this->click(trans('app.delete'));
        $this->press(trans('app.delete_confirm_button'));
        $this->seePageIs(route('projects.index'));
        $this->see(trans('project.deleted'));

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
        $project = factory(Project::class)->create(['customer_id' => $customer->id]);

        $this->visit('projects/'.$project->id.'/edit');
        $this->seePageIs('projects/'.$project->id.'/edit');

        $this->type('Edit Project', 'name');
        $this->type('2016-04-15', 'proposal_date');
        $this->type('2016-04-25', 'start_date');
        $this->type('2016-05-05', 'end_date');
        $this->type(2000000, 'proposal_value');
        $this->type(2000000, 'project_value');
        $this->select(4, 'status_id');
        $this->select($customer->id, 'customer_id');
        $this->type('Edit deskripsi project', 'description');
        $this->press(trans('project.update'));

        $this->seeInDatabase('projects', [
            'id'            => $project->id,
            'name'          => 'Edit Project',
            'proposal_date' => '2016-04-15',
            'start_date'    => '2016-04-25',
            'end_date'      => '2016-05-05',
            'customer_id'   => $customer->id,
            'description'   => 'Edit deskripsi project',
        ]);
    }

    /** @test */
    public function form_is_validated_on_invalid_project_entry()
    {
        $user = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create();

        $this->visit(route('projects.index'));
        $this->seePageIs(route('projects.index'));
        $this->click(trans('project.create'));
        $this->seePageIs(route('projects.create'));
        $this->type('', 'name');
        $this->select($customer->id, 'customer_id');
        $this->type('2016-04-15aa', 'proposal_date');
        $this->type('', 'proposal_value');
        $this->type('Deskripsi project baru', 'description');
        $this->press(trans('project.create'));

        $this->seePageIs(route('projects.create'));
        $this->see(__('validation.flash_message'));
    }

    /** @test */
    public function admin_can_update_project_status_on_project_detail_page()
    {
        $user = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create();
        $project = factory(Project::class)->create([
            'customer_id' => $customer->id,
            'status_id'   => 1,
        ]);

        $this->visit(route('projects.show', $project->id));
        $this->seePageIs(route('projects.show', $project->id));
        $this->select(2, 'status_id');
        $this->press('Update Project Status');
        $this->see(trans('project.updated'));
        $this->seePageIs(route('projects.show', $project->id));

        $this->seeInDatabase('projects', [
            'id'        => $project->id,
            'status_id' => 2,
        ]);
    }
}

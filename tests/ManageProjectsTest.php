<?php

use App\Entities\Projects\Project;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ManageProjectsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function admin_can_input_new_project_with_existing_customer()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $user = factory(User::class)->create();
        $user->assignRole('customer');

        $this->visit('/projects');
        $this->seePageIs('/projects');
        $this->click(trans('project.create'));
        $this->seePageIs('/projects/create');
        $this->type('Project Baru','name');
        $this->select($user->id,'customer_id');
        $this->type('2016-04-15','proposal_date');
        $this->type('2000000','proposal_value');
        $this->type('Deskripsi project baru','description');
        $this->press(trans('project.create'));
        $this->seePageIs('/projects');
        $this->see(trans('project.created'));
        $this->see('Project Baru');
        $this->seeInDatabase('projects', ['name' => 'Project Baru', 'proposal_value' => '2000000']);
    }

    /** @test */
    public function admin_can_input_new_project_with_new_customer()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $this->visit('/projects');
        $this->seePageIs('/projects');
        $this->click(trans('project.create'));
        $this->seePageIs('/projects/create');

        // Invalid entry
        $this->type('Project Baru','name');
        $this->select('','customer_id');
        $this->type('2016-04-15','proposal_date');
        $this->type('2000000','proposal_value');
        $this->type('Deskripsi project baru','description');
        $this->press(trans('project.create'));
        $this->seePageIs('/projects/create');
        $this->notSeeInDatabase('projects', ['name' => 'Project Baru', 'proposal_value' => '2000000']);

        $this->type('Customer Baru','customer_name');
        $this->type('email@customer.baru','customer_email');
        $this->press(trans('project.create'));
        $this->seePageIs('/projects');
        $this->see(trans('project.created'));
        $this->see('Project Baru');
        $this->seeInDatabase('users', ['name' => 'Customer Baru', 'email' => 'email@customer.baru']);
        $newCustomer = User::whereName('Customer Baru')->whereEmail('email@customer.baru')->first();
        $this->seeInDatabase('projects', ['name' => 'Project Baru', 'proposal_value' => '2000000', 'customer_id' => $newCustomer->id]);
    }

    /** @test */
    public function admin_can_delete_a_project()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $project = factory(Project::class)->create();
        $this->visit('/projects');
        $this->click(trans('app.edit'));
        $this->click(trans('app.delete'));
        $this->press(trans('app.delete_confirm_button'));
        $this->seePageIs('projects');
        $this->see(trans('project.deleted'));
    }
}

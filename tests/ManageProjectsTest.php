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
        $users = factory(User::class, 2)->create();
        $users[0]->assignRole('admin');
        $this->actingAs($users[0]);

        $users[1]->assignRole('customer');

        $this->visit('/projects');
        $this->seePageIs('/projects');
        $this->click(trans('project.create'));
        $this->seePageIs('/projects/create');
        $this->type('Project Baru','name');
        $this->select($users[1]->id,'customer_id');
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

        $project = factory(Project::class)->create(['owner_id' => $user->id]);
        $this->visit('/projects?status=' . $project->status_id);
        $this->click(trans('app.edit'));
        $this->click(trans('app.delete'));
        $this->press(trans('app.delete_confirm_button'));
        $this->seePageIs('projects');
        $this->see(trans('project.deleted'));
    }

    /** @test */
    public function admin_can_edit_a_project()
    {
        $users = factory(User::class, 2)->create();
        $users[0]->assignRole('admin');
        $this->actingAs($users[0]);

        $project = factory(Project::class)->create(['owner_id' => $users[0]->id]);
        $users[1]->assignRole('customer');

        $this->visit('projects/' . $project->id . '/edit');
        $this->seePageIs('projects/' . $project->id . '/edit');

        $this->type('Edit Project','name');
        $this->type('2016-04-15','proposal_date');
        $this->type('2016-04-25','start_date');
        $this->type('2016-05-05','end_date');
        $this->type(2000000,'proposal_value');
        $this->type(2000000,'project_value');
        $this->select(4,'status_id');
        $this->select($users[1]->id,'customer_id');
        $this->type('Edit deskripsi project','description');
        $this->press(trans('project.update'));

        $this->seeInDatabase('projects',[
            'id' => $project->id,
            'name' => 'Edit Project',
            'proposal_date' => '2016-04-15',
            'start_date' => '2016-04-25',
            'end_date' => '2016-05-05',
            'customer_id' => $users[1]->id,
            'description' => 'Edit deskripsi project',
        ]);
    }

    /** @test */
    public function form_is_validated_on_invalid_project_entry()
    {
        $users = factory(User::class, 2)->create();
        $users[0]->assignRole('admin');
        $this->actingAs($users[0]);

        $users[1]->assignRole('customer');

        $this->visit('/projects');
        $this->seePageIs('/projects');
        $this->click(trans('project.create'));
        $this->seePageIs('/projects/create');
        $this->type('','name');
        $this->select($users[1]->id,'customer_id');
        $this->type('2016-04-15aa','proposal_date');
        $this->type('','proposal_value');
        $this->type('Deskripsi project baru','description');
        $this->press(trans('project.create'));
        $this->seePageIs('/projects/create');
        $this->see('Mohon periksa kembali form isian Anda.');
    }

}

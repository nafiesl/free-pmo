<?php

namespace Tests\Feature\Users;

use App\Entities\Users\User;
use Tests\TestCase;

class ManageUsersTest extends TestCase
{
    /** @test */
    public function user_can_see_user_list_from_dashboard_tab()
    {
        $admin  = $this->adminUserSigningIn();
        $agency = $admin->agency;

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $agency->addWorker($user1);
        $agency->addWorker($user2);

        $this->visit(route('users.index'));
        $this->see($user1->name);
        $this->see($user2->name);
    }

    /** @test */
    public function admin_can_insert_new_user()
    {
        $admin = $this->adminUserSigningIn();

        $this->visit(route('users.index'));
        $this->click(trans('user.create'));
        $this->seePageIs(route('users.create'));
        $this->submitForm(trans('user.create'), [
            'name'                  => 'Nama User',
            'email'                 => 'user@mail.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->seePageIs(route('users.index'));
        $this->see(trans('user.created'));
        $this->see('Nama User');
        $this->see('user@mail.com');

        $this->seeInDatabase('users', [
            'name'  => 'Nama User',
            'email' => 'user@mail.com',
        ]);
    }

    /** @test */
    public function admin_can_edit_user_data()
    {
        $admin = $this->adminUserSigningIn();
        $user2 = factory(User::class)->create();
        $admin->agency->addWorker($user2);

        $this->visit(route('users.edit', $user2->id));
        $this->type('Ganti nama User', 'name');
        $this->type('member@mail.dev', 'email');
        $this->press(trans('user.update'));

        $this->seePageIs(route('users.edit', $user2->id));

        $this->see(trans('user.updated'));
        $this->see('Ganti nama User');
        $this->see('member@mail.dev');

        $this->seeInDatabase('users', [
            'id'    => $user2->id,
            'name'  => 'Ganti nama User',
            'email' => 'member@mail.dev',
        ]);
    }

    /** @test */
    public function admin_can_deleta_a_user()
    {
        $admin = $this->adminUserSigningIn();
        $user2 = factory(User::class)->create();
        $admin->agency->addWorker($user2);

        $this->visit(route('users.edit', $user2->id));

        $this->seeInDatabase('users', [
            'id'    => $user2->id,
            'name'  => $user2->name,
            'email' => $user2->email,
        ]);

        $this->click(trans('app.delete'));
        $this->seePageIs(route('users.delete', $user2->id));
        $this->press(trans('app.delete_confirm_button'));

        $this->seePageIs(route('users.index'));
        $this->see(trans('user.deleted'));

        $this->notSeeInDatabase('users', [
            'id'       => $user2->id,
            'name'     => $user2->name,
            'username' => $user2->username,
            'email'    => $user2->email,
        ]);

        $this->notSeeInDatabase('agency_workers', [
            'agency_id' => $admin->agency->id,
            'worker_id' => $user2->id,
        ]);
    }
}

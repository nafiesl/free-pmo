<?php

use App\Entities\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ManageUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function admin_can_insert_new_user()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $this->visit('/users');
        $this->click(trans('user.create'));
        $this->seePageIs('users/create');
        $this->submitForm(trans('user.create'), [
            'name' => 'Nama User',
            'username' => 'user_name',
            'email' => 'user@mail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => [1,2],
        ]);
        $this->seePageIs('users');
        $this->see(trans('user.created'));
        $this->see('Nama User');
        $this->see('user@mail.com');
        $this->seeInDatabase('users',['name' => 'Nama User','username' => 'user_name', 'email' => 'user@mail.com']);
    }

    /** @test */
    public function admin_can_edit_user_data()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $user2 = factory(User::class)->create();
        $user2->assignRole('customer');

        $this->visit('users/' . $user2->id . '/edit');
        $this->type('Ganti nama User', 'name');
        $this->type('user_name', 'username');
        $this->type('member@mail.dev', 'email');
        $this->press(trans('user.update'));
        $this->seePageIs('users/' . $user2->id . '/edit');
        $this->see(trans('user.updated'));
        $this->see('Ganti nama User');
        $this->see('user_name');
        $this->see('member@mail.dev');
        $this->seeInDatabase('users', ['id' => $user2->id, 'name' => 'Ganti nama User', 'username' => 'user_name','email' => 'member@mail.dev']);
    }

    /** @test */
    public function admin_can_deleta_a_user()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $user2 = factory(User::class)->create();
        $user2->assignRole('customer');

        $this->visit('users/' . $user2->id . '/edit');
        $this->seeInDatabase('users', ['id' => $user2->id, 'name' => $user2->name, 'username' => $user2->username,'email' => $user2->email]);
        $this->click(trans('app.delete'));
        $this->seePageIs('users/' . $user2->id . '/delete');
        $this->press(trans('app.delete_confirm_button'));
        $this->seePageIs('users');
        $this->see(trans('user.deleted'));
        $this->notSeeInDatabase('users', ['id' => $user2->id, 'name' => $user2->name, 'username' => $user2->username,'email' => $user2->email]);
    }
}

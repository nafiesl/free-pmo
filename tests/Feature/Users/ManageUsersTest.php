<?php

namespace Tests\Feature\Users;

use App\Entities\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Manage Users Feature Test.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class ManageUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_user_list_from_dashboard_tab()
    {
        $admin = $this->adminUserSigningIn();

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $this->visit(route('users.index'));
        $this->see($user1->name);
        $this->see($user2->name);
    }

    /** @test */
    public function admin_can_insert_new_user()
    {
        $admin = $this->adminUserSigningIn();

        $this->visit(route('users.index'));
        $this->click(__('user.create'));
        $this->seePageIs(route('users.create'));

        $this->submitForm(__('user.create'), [
            'name' => 'Nama User',
            'email' => 'user@mail.com',
            'password' => 'password',
            'role' => [1, 2], // Administrator, Worker
        ]);

        $this->seePageIs(route('users.index'));
        $this->see(__('user.created'));
        $this->see('Nama User');
        $this->see('user@mail.com');

        $newUser = User::where('email', 'user@mail.com')->first();

        $this->assertEquals('Nama User', $newUser->name);

        $this->assertTrue($newUser->hasRoles(['admin', 'worker']));

        $this->assertTrue($newUser->hasRole('admin'));
        $this->assertTrue($newUser->hasRole('worker'));
        $this->assertNotNull($newUser->api_token);

        // $this->seeInDatabase('users', [
        //     'id'    => $newUser->id,
        //     'name'  => 'Nama User',
        //     'email' => 'user@mail.com',
        // ]);

        // $this->seeInDatabase('user_roles', [
        //     'user_id' => $newUser->id,
        //     'role_id' => 1,
        // ]);

        // $this->seeInDatabase('user_roles', [
        //     'user_id' => $newUser->id,
        //     'role_id' => 2,
        // ]);
    }

    /** @test */
    public function admin_can_edit_user_data()
    {
        $admin = $this->adminUserSigningIn();
        $user2 = factory(User::class)->create();
        $user2->assignRole('worker');

        $this->visit(route('users.edit', $user2->id));

        $this->submitForm(__('user.update'), [
            'name' => 'Ganti nama User',
            'email' => 'member@mail.dev',
            'password' => 'password',
            'role' => [1, 2], // Administrator, Worker
            'lang' => 'id',
        ]);

        $this->seePageIs(route('users.edit', $user2->id));

        $this->see(__('user.updated'));

        $this->seeInDatabase('users', [
            'id' => $user2->id,
            'name' => 'Ganti nama User',
            'email' => 'member@mail.dev',
            'lang' => 'id',
        ]);

        $this->seeInDatabase('user_roles', [
            'user_id' => $user2->id,
            'role_id' => 1,
        ]);

        $this->seeInDatabase('user_roles', [
            'user_id' => $user2->id,
            'role_id' => 2,
        ]);

        $this->assertTrue(
            app('hash')->check('password', $user2->fresh()->password),
            'The password should changed!'
        );
    }

    /** @test */
    public function admin_can_deleta_a_user()
    {
        $admin = $this->adminUserSigningIn();
        $user2 = factory(User::class)->create();

        $this->visit(route('users.edit', $user2->id));

        $this->seeInDatabase('users', [
            'id' => $user2->id,
            'name' => $user2->name,
            'email' => $user2->email,
        ]);

        $this->click(__('app.delete'));
        $this->seePageIs(route('users.delete', $user2->id));
        $this->press(__('app.delete_confirm_button'));

        $this->seePageIs(route('users.index'));
        $this->see(__('user.deleted'));

        $this->notSeeInDatabase('users', [
            'id' => $user2->id,
            'name' => $user2->name,
            'username' => $user2->username,
            'email' => $user2->email,
        ]);
    }
}

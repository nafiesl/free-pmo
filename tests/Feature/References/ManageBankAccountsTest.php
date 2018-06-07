<?php

namespace Tests\Feature\References;

use Option;
use Tests\TestCase as TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Manage Bank Account Feature Test.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class ManageBankAccountsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_see_bank_account_list_in_bank_account_index_page()
    {
        $this->adminUserSigningIn();
        $this->visit(route('bank-accounts.index'));
    }

    /** @test */
    public function user_can_create_a_bank_account()
    {
        $this->adminUserSigningIn();
        $this->visit(route('bank-accounts.index'));

        $this->click(trans('bank_account.create'));
        $this->seePageIs(route('bank-accounts.index', ['action' => 'create']));

        $this->submitForm(trans('bank_account.create'), [
            'name'         => 'BankAccount 1 name',
            'number'       => '1234567890',
            'account_name' => 'John Doe',
            'description'  => 'BankAccount 1 description',
        ]);

        $this->seePageIs(route('bank-accounts.index'));

        $bankAccounts = [];

        $bankAccounts[1] = [
            'name'         => 'BankAccount 1 name',
            'number'       => '1234567890',
            'account_name' => 'John Doe',
            'description'  => 'BankAccount 1 description',
        ];

        $this->seeInDatabase('site_options', [
            'value' => json_encode($bankAccounts),
        ]);
    }

    /** @test */
    public function user_can_edit_a_bank_account_within_search_query()
    {
        $this->adminUserSigningIn();

        $bankAccounts = [];
        $bankAccounts[1] = [
            'name'         => 'BankAccount 1 name',
            'number'       => '1234567890',
            'account_name' => 'John Doe',
            'description'  => 'BankAccount 1 description',
        ];

        Option::set('bank_accounts', json_encode($bankAccounts));

        $this->visit(route('bank-accounts.index'));
        $this->click('edit-bank_account-1');
        $this->seePageIs(route('bank-accounts.index', ['action' => 'edit', 'id' => '1']));

        $this->submitForm(trans('bank_account.update'), [
            'name'         => 'BankAccount 2 name',
            'number'       => '1234567890',
            'account_name' => 'John Doe',
            'description'  => 'BankAccount 2 description',
        ]);

        $this->seePageIs(route('bank-accounts.index'));

        $bankAccounts[1] = [
            'name'         => 'BankAccount 2 name',
            'number'       => '1234567890',
            'account_name' => 'John Doe',
            'description'  => 'BankAccount 2 description',
        ];

        $this->seeInDatabase('site_options', [
            'value' => json_encode($bankAccounts),
        ]);
    }

    /** @test */
    public function user_can_delete_a_bank_account()
    {
        $this->adminUserSigningIn();

        $bankAccounts = [];
        $bankAccounts[2] = [
            'name'         => 'BankAccount 1 name',
            'number'       => '1234567890',
            'account_name' => 'John Doe',
            'description'  => 'BankAccount 1 description',
        ];

        Option::set('bank_accounts', json_encode($bankAccounts));

        $this->seeInDatabase('site_options', [
            'value' => json_encode($bankAccounts),
        ]);

        $this->visit(route('bank-accounts.index'));
        $this->click('del-bank_account-2');
        $this->seePageIs(route('bank-accounts.index', ['action' => 'delete', 'id' => '2']));

        $this->press(trans('app.delete_confirm_button'));

        $this->dontSeeInDatabase('site_options', [
            'value' => json_encode($bankAccounts),
        ]);
    }
}

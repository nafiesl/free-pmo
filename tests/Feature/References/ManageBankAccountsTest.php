<?php

namespace Tests\Feature\References;

use Tests\TestCase;
use App\Entities\Invoices\BankAccount;
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
        $bankAccount = factory(BankAccount::class)->create();
        $this->visit(route('bank-accounts.index'));

        $this->seeText($bankAccount->name);
    }

    /** @test */
    public function user_can_create_a_bank_account()
    {
        $this->adminUserSigningIn();
        $this->visit(route('bank-accounts.index'));

        $this->click(__('bank_account.create'));
        $this->seePageIs(route('bank-accounts.index', ['action' => 'create']));

        $this->submitForm(__('bank_account.create'), [
            'name'         => 'BankAccount 1 name',
            'number'       => '1234567890',
            'account_name' => 'John Doe',
            'description'  => 'BankAccount 1 description',
        ]);

        $this->seePageIs(route('bank-accounts.index'));

        $this->seeInDatabase('bank_accounts', [
            'name'         => 'BankAccount 1 name',
            'number'       => '1234567890',
            'account_name' => 'John Doe',
            'description'  => 'BankAccount 1 description',
        ]);
    }

    /** @test */
    public function user_can_edit_a_bank_account()
    {
        $this->adminUserSigningIn();

        $bankAccount = factory(BankAccount::class)->create();

        $this->visit(route('bank-accounts.index'));
        $this->click('edit-bank_account-1');

        $this->seePageIs(route('bank-accounts.index', [
            'action' => 'edit', 'id' => $bankAccount->id,
        ]));

        $this->submitForm(__('bank_account.update'), [
            'name'         => 'BankAccount 2 name',
            'number'       => '1234567890',
            'account_name' => 'John Doe',
            'description'  => 'BankAccount 2 description',
        ]);

        $this->seePageIs(route('bank-accounts.index'));

        $this->seeInDatabase('bank_accounts', [
            'name'         => 'BankAccount 2 name',
            'number'       => '1234567890',
            'account_name' => 'John Doe',
            'description'  => 'BankAccount 2 description',
        ]);
    }

    /** @test */
    public function user_can_delete_a_bank_account()
    {
        $this->adminUserSigningIn();

        $bankAccount = factory(BankAccount::class)->create();

        $this->visit(route('bank-accounts.index'));
        $this->click('del-bank_account-'.$bankAccount->id);

        $this->seePageIs(route('bank-accounts.index', [
            'action' => 'delete', 'id' => $bankAccount->id,
        ]));

        $this->press(__('app.delete_confirm_button'));

        $this->dontSeeInDatabase('bank_accounts', [
            'id' => $bankAccount->id,
        ]);
    }
}

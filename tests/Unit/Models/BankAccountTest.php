<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Entities\Invoices\BankAccount;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BankAccountTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_bank_account_has_status_attribute()
    {
        $bankAccount = factory(BankAccount::class)->make(['is_active' => 1]);
        $this->assertEquals(__('app.active'), $bankAccount->status);

        $bankAccount->is_active = 0;
        $this->assertEquals(__('app.in_active'), $bankAccount->status);
    }
}

<?php

namespace Tests\Feature\Payments;

use App\Entities\Payments\Payment;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class PaymentSearchTest extends TestCase
{
    /** @test */
    public function user_can_find_payment_by_customer_id()
    {
        $admin = $this->adminUserSigningIn();
        $payment = factory(Payment::class)->create(['owner_id' => $admin->id]);
        $unShownPayment = factory(Payment::class)->create(['owner_id' => $admin->id]);

        $this->visit(route('payments.index', ['customer_id' => $payment->customer_id]));
        $this->seePageIs(route('payments.index', ['customer_id' => $payment->customer_id]));

        $this->see($payment->project->name);
        $this->dontSee($unShownPayment->project->name);
    }
}

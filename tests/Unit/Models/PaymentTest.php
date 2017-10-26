<?php

namespace Tests\Unit\Models;

use App\Entities\Payments\Payment;
use App\Entities\Users\User;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    /** @test */
    public function it_has_customer_relation()
    {
        $payment = factory(Payment::class)->create();
        $this->assertTrue($payment->customer instanceof User);
    }
}

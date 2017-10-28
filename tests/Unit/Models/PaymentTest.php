<?php

namespace Tests\Unit\Models;

use App\Entities\Partners\Partner;
use App\Entities\Payments\Payment;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    /** @test */
    public function it_has_partner_relation()
    {
        $payment = factory(Payment::class)->create();
        $this->assertTrue($payment->partner instanceof Partner);
    }
}

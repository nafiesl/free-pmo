<?php

namespace Tests\Unit\Models;

use App\Entities\Partners\Customer;
use App\Entities\Partners\Vendor;
use App\Entities\Payments\Payment;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    /** @test */
    public function it_has_partner_relation()
    {
        $payment = factory(Payment::class, 'income')->create(['in_out' => 1]);
        $this->assertTrue($payment->partner instanceof Customer);

        $payment = factory(Payment::class, 'expanse')->create(['in_out' => 0]);
        $this->assertTrue($payment->partner instanceof Vendor);
    }
}

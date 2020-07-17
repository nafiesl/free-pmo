<?php

namespace Tests\Unit\Models;

use App\Entities\Partners\Customer;
use App\Entities\Partners\Vendor;
use App\Entities\Payments\Payment;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_have_partner_relation_on_customer_model_for_income_payment()
    {
        $payment = factory(Payment::class)->create();
        $this->assertInstanceOf(Customer::class, $payment->partner);

        $payment = factory(Payment::class)->states('customer')->create();
        $this->assertInstanceOf(Customer::class, $payment->partner);
    }

    /** @test */
    public function it_can_have_partner_relation_on_vendor_model_for_expanse_payment()
    {
        $payment = factory(Payment::class)->states('vendor')->create();
        $this->assertInstanceOf(Vendor::class, $payment->partner);
    }

    /** @test */
    public function it_can_have_partner_relation_on_user_model_for_fee_payment()
    {
        $payment = factory(Payment::class)->states('fee')->create();
        $this->assertInstanceOf(User::class, $payment->partner);
    }
}

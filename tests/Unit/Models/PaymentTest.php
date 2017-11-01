<?php

namespace Tests\Unit\Models;

use App\Entities\Partners\Customer;
use App\Entities\Partners\Vendor;
use App\Entities\Payments\Payment;
use App\Entities\Users\User;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    /** @test */
    public function it_can_have_partner_relation_on_customer_model_for_income_payment()
    {
        $payment = factory(Payment::class)->create();
        $this->assertTrue(
            $payment->partner instanceof Customer,
            'An income payment should have a App\Entities\Partners\Customer model as partner relation'
        );
    }

    /** @test */
    public function it_can_have_partner_relation_on_vendor_model_for_expanse_payment()
    {
        $payment = factory(Payment::class)->states('vendor')->create();
        $this->assertTrue(
            $payment->partner instanceof Vendor,
            'An expanse payment can have a App\Entities\Partners\Vendor model as partner relation'
        );
    }

    /** @test */
    public function it_can_have_partner_relation_on_user_model_for_fee_payment()
    {
        $payment = factory(Payment::class)->states('fee')->create();
        $this->assertTrue(
            $payment->partner instanceof User,
            'An expanse payment can have a App\Entities\Users\User model as partner relation'
        );
    }
}

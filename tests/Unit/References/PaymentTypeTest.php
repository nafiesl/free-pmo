<?php

namespace Tests\Unit\References;

use App\Entities\Payments\Type;
use Tests\TestCase;

class PaymentTypeTest extends TestCase
{
    /** @test */
    public function retrieve_payment_type_list()
    {
        $paymentType = new Type();

        $this->assertEquals([
            1 => __('payment.types.project'),
            2 => __('payment.types.add_job'),
            3 => __('payment.types.maintenance'),
        ], $paymentType->toArray());
    }

    /** @test */
    public function retrieve_payment_type_name_by_id()
    {
        $paymentType = new Type();

        $this->assertEquals(__('payment.types.project'), $paymentType->getNameById(1));
        $this->assertEquals(__('payment.types.add_job'), $paymentType->getNameById(2));
        $this->assertEquals(__('payment.types.maintenance'), $paymentType->getNameById(3));
    }

    /** @test */
    public function retrieve_payment_type_color_class_by_id()
    {
        $paymentType = new Type();

        $this->assertEquals('#337ab7', $paymentType->getColorById(1));
        $this->assertEquals('#4caf50', $paymentType->getColorById(2));
        $this->assertEquals('#ff8181', $paymentType->getColorById(3));
    }
}

<?php

namespace Tests\Unit\Reference;

use Tests\TestCase;
use App\Entities\Subscriptions\Type;

class SubscriptionTypeTest extends TestCase
{
    /** @test */
    public function retrieve_subscription_type_list()
    {
        $subscriptionType = new Type();

        $this->assertEquals([
            1 => trans('subscription.types.domain'),
            2 => trans('subscription.types.hosting'),
            3 => trans('subscription.types.maintenance'),
        ], $subscriptionType->toArray());
    }

    /** @test */
    public function retrieve_subscription_type_name_by_id()
    {
        $subscriptionType = new Type();

        $this->assertEquals(trans('subscription.types.domain'), $subscriptionType->getNameById(1));
        $this->assertEquals(trans('subscription.types.hosting'), $subscriptionType->getNameById(2));
        $this->assertEquals(trans('subscription.types.maintenance'), $subscriptionType->getNameById(3));
    }

    /** @test */
    public function retrieve_subscription_type_color_class_by_id()
    {
        $subscriptionType = new Type();

        $this->assertEquals('#337ab7', $subscriptionType->getColorById(1));
        $this->assertEquals('#4caf50', $subscriptionType->getColorById(2));
        $this->assertEquals('#00b3ff', $subscriptionType->getColorById(3));
    }
}

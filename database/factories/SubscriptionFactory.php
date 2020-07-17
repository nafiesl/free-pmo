<?php

use App\Entities\Partners\Customer;
use App\Entities\Partners\Vendor;
use App\Entities\Projects\Project;
use App\Entities\Subscriptions\Subscription;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Subscription::class, function (Faker $faker) {
    $startDate = Carbon::parse($faker->dateTimeBetween('-1 year', '-1 month')->format('Y-m-d'));

    return [
        'project_id'  => function () {
            return factory(Project::class)->create()->id;
        },
        'type_id'     => 1,
        'status_id'   => 1,
        'name'        => 'www.'.Str::random(10).'.com',
        'price'       => 125000,
        'start_date'  => $startDate->format('Y-m-d'),
        'due_date'    => $startDate->addYears(1)->format('Y-m-d'),
        'customer_id' => function () {
            return factory(Customer::class)->create()->id;
        },
        'vendor_id'   => function () {
            return factory(Vendor::class)->create()->id;
        },
    ];
});

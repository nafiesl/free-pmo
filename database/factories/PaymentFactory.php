<?php

use App\Entities\Partners\Customer;
use App\Entities\Partners\Vendor;
use App\Entities\Payments\Payment;
use App\Entities\Projects\Project;
use App\Entities\Users\User;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'project_id'   => function () {
            return factory(Project::class)->create()->id;
        },
        'amount'       => 10000,
        'in_out'       => 1,
        'type_id'      => 1,
        'date'         => $faker->dateTimeBetween('-1 year', '-1 month')->format('Y-m-d'),
        'description'  => $faker->paragraph,
        'partner_type' => Customer::class,
        'partner_id'   => function () {
            return factory(Customer::class)->create()->id;
        },
    ];
});

$factory->state(Payment::class, 'customer', function (Faker $faker) {
    return [];
});

$factory->state(Payment::class, 'vendor', function (Faker $faker) {
    return [
        'in_out'       => 0,
        'type_id'      => 1,
        'partner_type' => Vendor::class,
        'partner_id'   => function () {
            return factory(Vendor::class)->create()->id;
        },
    ];
});

$factory->state(Payment::class, 'fee', function (Faker $faker) {
    return [
        'in_out'       => 0,
        'type_id'      => 1,
        'partner_type' => User::class,
        'partner_id'   => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

<?php

use App\Entities\Agencies\Agency;
use App\Entities\Partners\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {

    return [
        'name'     => $faker->company,
        'owner_id' => function () {
            return factory(Agency::class)->create()->id;
        },
    ];
});

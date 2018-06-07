<?php

use Faker\Generator as Faker;
use App\Entities\Partners\Customer;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'name'     => $faker->company,
    ];
});

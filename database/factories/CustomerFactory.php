<?php

use App\Entities\Partners\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'name'     => $faker->company,
    ];
});

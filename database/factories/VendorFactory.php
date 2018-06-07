<?php

use Faker\Generator as Faker;
use App\Entities\Partners\Vendor;

$factory->define(Vendor::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
    ];
});

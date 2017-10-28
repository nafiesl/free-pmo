<?php

use App\Entities\Partners\Partner;
use Faker\Generator as Faker;

$factory->define(Partner::class, function (Faker $faker) {

    return [
        'name' => $faker->company,
    ];
});

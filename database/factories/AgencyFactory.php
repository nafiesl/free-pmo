<?php

use App\Entities\Agencies\Agency;
use App\Entities\Users\User;
use Faker\Generator as Faker;

$factory->define(Agency::class, function (Faker $faker) {
    return [
        'name'     => $faker->company,
        'email'    => $faker->safeEmail,
        'owner_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

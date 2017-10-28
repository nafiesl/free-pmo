<?php

use App\Entities\Agencies\Agency;
use App\Entities\Partners\Partner;
use Faker\Generator as Faker;

$factory->define(Partner::class, function (Faker $faker) {

    return [
        'name'     => $faker->company,
        'owner_id' => function () {
            return factory(Agency::class)->create()->id;
        },
    ];
});

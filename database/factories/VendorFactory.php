<?php

use App\Entities\Agencies\Agency;
use App\Entities\Partners\Vendor;
use Faker\Generator as Faker;

$factory->define(Vendor::class, function (Faker $faker) {

    return [
        'name'     => $faker->word,
        'owner_id' => function () {
            return factory(Agency::class)->create()->id;
        },
    ];
});

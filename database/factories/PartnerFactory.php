<?php

use App\Entities\Agencies\Agency;
use App\Entities\Partners\Partner;
use Faker\Generator as Faker;

$factory->define(Partner::class, function (Faker $faker) {

    return [
        'name'     => $faker->company,
        'type_id'  => 1, // 1:Customer, 2:Vendor
        'owner_id' => function () {
            return factory(Agency::class)->create()->id;
        },
    ];
});

$factory->defineAs(Partner::class, 'customer', function (Faker $faker) {

    return [
        'name'     => $faker->company,
        'type_id'  => 1, // 1:Customer, 2:Vendor
        'owner_id' => function () {
            return factory(Agency::class)->create()->id;
        },
    ];
});

$factory->defineAs(Partner::class, 'vendor', function (Faker $faker) {

    return [
        'name'     => $faker->company,
        'type_id'  => 2, // 1:Customer, 2:Vendor
        'owner_id' => function () {
            return factory(Agency::class)->create()->id;
        },
    ];
});

<?php

use Faker\Generator as Faker;
use App\Entities\Invoices\BankAccount;

$factory->define(BankAccount::class, function (Faker $faker) {
    return [
        'name'         => 'Bank '.strtoupper(str_random(4)),
        'number'       => str_random(10),
        'account_name' => $faker->name,
    ];
});

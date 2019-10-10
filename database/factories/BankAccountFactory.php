<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Entities\Invoices\BankAccount;

$factory->define(BankAccount::class, function (Faker $faker) {
    return [
        'name'         => 'Bank '.strtoupper(Str::random(4)),
        'number'       => Str::random(10),
        'account_name' => $faker->name,
    ];
});

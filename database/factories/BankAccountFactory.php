<?php

use App\Entities\Invoices\BankAccount;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(BankAccount::class, function (Faker $faker) {
    return [
        'name'         => 'Bank '.strtoupper(Str::random(4)),
        'number'       => Str::random(10),
        'account_name' => $faker->name,
    ];
});

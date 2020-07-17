<?php

use App\Entities\Invoices\Invoice;
use App\Entities\Projects\Project;
use App\Entities\Users\User;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'project_id' => function () {
            return factory(Project::class)->create()->id;
        },
        'number'     => (new Invoice())->generateNewNumber(),
        'items'      => [],
        'date'       => '2010-10-10',
        'amount'     => 100000,
        'status_id'  => 1,
        'creator_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

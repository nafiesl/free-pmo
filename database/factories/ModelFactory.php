<?php

use App\Entities\Invoices\Invoice;
use App\Entities\Partners\Partner;
use App\Entities\Projects\Feature;
use App\Entities\Projects\Project;
use App\Entities\Projects\Task;
use App\Entities\Subscriptions\Subscription;
use App\Entities\Users\Event;
use App\Entities\Users\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->email,
        'password'       => 'member',
        'remember_token' => str_random(10),
        'api_token'      => str_random(32),
    ];
});

$factory->define(Subscription::class, function (Faker\Generator $faker) {

    $startDate = Carbon::parse($faker->dateTimeBetween('-1 year', '-1 month')->format('Y-m-d'));

    return [
        'project_id'       => function () {
            return factory(Project::class)->create()->id;
        },
        'status_id'        => 1,
        'domain_name'      => 'www.'.str_random(10).'.com',
        'domain_price'     => 125000,
        'epp_code'         => str_random(10),
        'hosting_capacity' => rand(1, 3).' GB',
        'hosting_price'    => rand(1, 5) * 100000,
        'start_date'       => $startDate->format('Y-m-d'),
        'due_date'         => $startDate->addYears(1)->format('Y-m-d'),
        'remark'           => $faker->paragraph,
        'vendor_id'        => function () {
            return factory(Partner::class)->create()->id;
        },
    ];
});

$factory->define(Feature::class, function (Faker\Generator $faker) {

    return [
        'project_id'  => function () {
            return factory(Project::class)->create()->id;
        },
        'name'        => $faker->sentence(3),
        'price'       => rand(1, 10) * 100000,
        'description' => $faker->paragraph,
        'worker_id'   => function () {
            return factory(User::class)->create()->id;
        },
        'type_id'     => 1, // Main feature
        'position'    => rand(1, 10),
    ];
});

$factory->define(Task::class, function (Faker\Generator $faker) {

    return [
        'feature_id'  => function () {
            return factory(Feature::class)->create()->id;
        },
        'name'        => $faker->sentence(3),
        'description' => $faker->paragraph,
        'progress'    => rand(40, 100),
        'route_name'  => implode('.', $faker->words(3)),
        'position'    => rand(1, 10),
    ];
});

$factory->define(Event::class, function (Faker\Generator $faker) {

    return [
        'user_id'    => function () {
            return factory(User::class)->create()->id;
        },
        'project_id' => function () {
            return factory(Project::class)->create()->id;
        },
        'title'      => $faker->words(rand(2, 4), true),
        'body'       => $faker->sentence,
        'start'      => $faker->dateTimeBetween('-2 months', '-2 months')->format('Y-m-d H:i:s'),
        'end'        => $faker->dateTimeBetween('-2 months', '-2 months')->format('Y-m-d H:i:s'),
        'is_allday'  => rand(0, 1),
    ];
});

$factory->define(Invoice::class, function (Faker\Generator $faker) {
    return [
        'project_id' => function () {
            return factory(Project::class)->create()->id;
        },
        'number'     => (new Invoice)->generateNewNumber(),
        'items'      => [],
        'amount'     => 100000,
        'notes'      => $faker->paragraph,
        'status_id'  => 1,
        'creator_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

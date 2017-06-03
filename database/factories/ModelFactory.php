<?php

use App\Entities\Payments\Payment;
use App\Entities\Projects\Feature;
use App\Entities\Projects\Project;
use App\Entities\Projects\Task;
use App\Entities\Subscriptions\Subscription;
use App\Entities\Users\Event;
use App\Entities\Users\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'username'       => $faker->unique()->username,
        'email'          => $email = $faker->unique()->email,
        'password'       => 'member',
        'remember_token' => str_random(10),
        'api_token'      => bcrypt($email),
    ];
});

$factory->define(Project::class, function (Faker\Generator $faker) {

    $proposalDate = $faker->dateTimeBetween('-1 year', '-1 month')->format('Y-m-d');
    $startDate = Carbon::parse($proposalDate)->addDays(10);
    $endDate = $startDate->addDays(rand(1,13) * 7);

    return [
        'name'           => $faker->sentence(3),
        'description'    => $faker->paragraph,
        'proposal_date'  => $proposalDate,
        'start_date'     => $startDate->format('Y-m-d'),
        'end_date'       => $endDate->format('Y-m-d'),
        'project_value'  => $projectValue = rand(1,10) * 500000,
        'proposal_value' => $projectValue,
        'status_id'      => rand(1,6),
        'owner_id'       => function () {
            return factory(User::class)->create()->id;
        },
        'customer_id'    => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

$factory->define(Payment::class, function (Faker\Generator $faker) {

    return [
        'project_id'  => function () {
            return factory(Project::class)->create()->id;
        },
        'amount'      => rand(1,5) * 500000,
        'in_out'      => rand(0,1),
        'type_id'     => rand(1,3),
        'date'        => $faker->dateTimeBetween('-1 year', '-1 month')->format('Y-m-d'),
        'description' => $faker->paragraph,
        'owner_id'    => function () {
            return factory(User::class)->create()->id;
        },
        'customer_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

$factory->define(Subscription::class, function (Faker\Generator $faker) {

    $startDate = Carbon::parse($faker->dateTimeBetween('-1 year', '-1 month')->format('Y-m-d'));

    return [
        'project_id'       => function () {
            return factory(Project::class)->create()->id;
        },
        'status_id'        => 1,
        'domain_name'      => 'www.' . str_random(10) . '.com',
        'domain_price'     => 125000,
        'epp_code'         => str_random(10),
        'hosting_capacity' => rand(1,3) . ' GB',
        'hosting_price'    => rand(1,5) * 100000,
        'start_date'       => $startDate->format('Y-m-d'),
        'due_date'         => $startDate->addYears(1)->format('Y-m-d'),
        'remark'           => $faker->paragraph,
        'customer_id'      => function () {
            return factory(User::class)->create()->id;
        },
        'vendor_id'        => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

$factory->define(Feature::class, function (Faker\Generator $faker) {

    return [
        'project_id'  => function () {
            return factory(Project::class)->create()->id;
        },
        'name'        => $faker->sentence(3),
        'price'       => rand(1,10) * 100000,
        'description' => $faker->paragraph,
        'worker_id'   => function () {
            return factory(User::class)->create()->id;
        },
        'type_id'     => rand(1,2),
        'position'    => rand(1,10),
    ];
});

$factory->define(Task::class, function (Faker\Generator $faker) {

    return [
        'feature_id'  => function () {
            return factory(Feature::class)->create()->id;
        },
        'name'        => $faker->sentence(3),
        'description' => $faker->paragraph,
        'progress'    => rand(40,100),
        'route_name'  => implode('.', $faker->words(3)),
        'position'    => rand(1,10),
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
        'title'      => $faker->words(rand(2,4), true),
        'body'       => $faker->sentence,
        'start'      => $faker->dateTimeBetween('-2 months', '-2 months')->format('Y-m-d H:i:s'),
        'end'        => $faker->dateTimeBetween('-2 months', '-2 months')->format('Y-m-d H:i:s'),
        'is_allday'  => rand(0,1),
    ];
});
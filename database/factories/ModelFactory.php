<?php

use App\Entities\Payments\Payment;
use App\Entities\Projects\Project;
use App\Entities\Subscriptions\Subscription;
use App\Entities\Users\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->username,
        'email' => $faker->email,
        'password' => 'member',
        'remember_token' => str_random(10),
    ];
});

$factory->define(Project::class, function (Faker\Generator $faker) {
    $proposalDate = $faker->dateTimeBetween('-1 year', '-1 month')->format('Y-m-d');
    $startDate = Carbon::parse($proposalDate)->addDays(10);
    $endDate = $startDate->addDays(rand(1,13) * 7);
    $customer = factory(User::class)->create();
    $customer->assignRole('customer');

    return [
        'name' => $faker->sentence,
        'description' => $faker->paragraph,
        'proposal_date' => $proposalDate,
        'start_date' => $startDate->format('Y-m-d'),
        'end_date' => $endDate->format('Y-m-d'),
        'project_value' => $projectValue = rand(1,10) * 500000,
        'proposal_value' => $projectValue,
        'status_id' => rand(1,6),
        'customer_id' => $customer->id
    ];
});

$factory->define(Payment::class, function (Faker\Generator $faker) {
    $projectId = factory(Project::class)->create()->id;

    $customer = factory(User::class)->create();
    $customer->assignRole('customer');
    $customerId = $customer->id;

    return [
        'project_id' => $projectId,
        'amount' => rand(1,5) * 500000,
        'type' => rand(0,1),
        'date' => $faker->dateTimeBetween('-1 year', '-1 month')->format('Y-m-d'),
        'description' => $faker->paragraph,
        'customer_id' => $customerId,
    ];
});

$factory->define(Subscription::class, function (Faker\Generator $faker) {
    $projectId = factory(Project::class)->create()->id;

    $customer = factory(User::class)->create();
    $customer->assignRole('customer');
    $customerId = $customer->id;
    $startDate = Carbon::parse($faker->dateTimeBetween('-1 year', '-1 month')->format('Y-m-d'));

    return [
        'project_id' => $projectId,
        'domain_name' => 'www.' . str_random(10) . '.com',
        'domain_price' => 125000,
        'epp_code' => str_random(10),
        'hosting_capacity' => rand(1,3) . ' GB',
        'hosting_price' => rand(1,5) * 100000,
        'start_date' => $startDate->format('Y-m-d'),
        'due_date' => $startDate->addYears(1)->format('Y-m-d'),
        'remark' => $faker->paragraph,
        'customer_id' => $customerId,
    ];
});
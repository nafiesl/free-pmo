<?php

use App\Entities\Partners\Customer;
use App\Entities\Projects\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    $proposalDate = $faker->dateTimeBetween('-1 year', '-1 month')->format('Y-m-d');
    $startDate = Carbon::parse($proposalDate)->addDays(10);
    $endDate = $startDate->addDays(rand(1, 13) * 7);

    return [
        'name'           => $faker->sentence(3),
        'description'    => $faker->paragraph,
        'proposal_date'  => $proposalDate,
        'start_date'     => $startDate->format('Y-m-d'),
        'end_date'       => $endDate->format('Y-m-d'),
        'project_value'  => $projectValue = rand(1, 10) * 500000,
        'proposal_value' => $projectValue,
        'status_id'      => rand(1, 6),
        'customer_id'    => function () {
            return factory(Customer::class)->create()->id;
        },
    ];
});

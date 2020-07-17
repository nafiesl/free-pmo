<?php

use App\Entities\Projects\Job;
use App\Entities\Projects\Project;
use App\Entities\Projects\Task;
use App\Entities\Users\Event;
use App\Entities\Users\User;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->email,
        'password'       => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => Str::random(10),
        'api_token'      => Str::random(32),
        'lang'           => 'en',
    ];
});

$factory->define(Job::class, function (Faker\Generator $faker) {
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
        'type_id'     => 1, // Main job
        'position'    => 1,
    ];
});

$factory->define(Task::class, function (Faker\Generator $faker) {
    return [
        'job_id'      => function () {
            return factory(Job::class)->create()->id;
        },
        'name'        => $faker->sentence(3),
        'description' => $faker->paragraph,
        'progress'    => rand(40, 100),
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

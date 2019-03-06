<?php

use App\Entities\Users\User;
use Faker\Generator as Faker;
use App\Entities\Projects\Issue;
use App\Entities\Projects\Project;

$factory->define(Issue::class, function (Faker $faker) {
    return [
        'project_id' => function () {
            return factory(Project::class)->create()->id;
        },
        'title'      => $faker->words(3, true),
        'body'       => $faker->sentences(3, true),
        'creator_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

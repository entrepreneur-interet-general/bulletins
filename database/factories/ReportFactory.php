<?php

use App\Report;
use Faker\Generator as Faker;

$factory->define(Report::class, function (Faker $faker) {
    return [
        'project' => $faker->randomElement(config('app.projects')->names()),
        'week_number' => now()->startOfWeek()->format('Y-W'),
        'spirit' => $faker->randomElement(['☹️', '😐', '🙂', '😀']),
        'priorities' => $faker->text(300),
        'victories' => $faker->text(300),
        'help' => $faker->randomElement([$faker->text(300), null]),
    ];
});

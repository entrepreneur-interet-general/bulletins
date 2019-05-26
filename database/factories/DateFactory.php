<?php

use App\Date;
use Faker\Generator as Faker;

$factory->define(Date::class, function (Faker $faker) {
    return [
        'project'     => $faker->randomElement(config('app.projects')->names()),
        'date'        => $faker->dateTimeThisYear(now()->addYear(1))->format('Y-m-d'),
        'description' => $faker->text(100),
    ];
});

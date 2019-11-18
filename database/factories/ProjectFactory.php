<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Project;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name' => 'The name',
        'channel' => 'slack',
        'members' => [],
        'logoUrl' => 'img.jpg',
        'endsOn' => Carbon::tomorrow(),
    ];
});

$factory->state(Project::class, 'inactive', [
    'endsOn' => Carbon::yesterday(),
]);

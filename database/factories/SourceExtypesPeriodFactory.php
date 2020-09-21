<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SourceExtypePeriod;
use Faker\Generator as Faker;

$factory->define(SourceExtypePeriod::class, function (Faker $faker) {
    return [
        'extype_id' => $faker->numberBetween(1, 17),
        'source_id' => $faker->numberBetween(1, 6),
        'default' => $faker->optional()->randomFloat(2),
        'start_year' => $faker->numberBetween(2017, 2020),
        'end_year' => $faker->numberBetween(2020, 2022),
        'start_month' => sprintf("%02d", $faker->numberBetween(1, 6)),
        'end_month' => sprintf("%02d", $faker->numberBetween(6, 12)),
        'details' => $faker->optional()->text(200),
    ];
});

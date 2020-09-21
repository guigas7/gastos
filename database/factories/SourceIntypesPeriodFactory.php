<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SourceIntypePeriod;
use Faker\Generator as Faker;

$factory->define(SourceIntypePeriod::class, function (Faker $faker) {
    return [
        'intype_id' => $faker->numberBetween(1, 12),
        'source_id' => $faker->numberBetween(1, 6),
        'start_year' => $faker->numberBetween(2017, 2020),
        'end_year' => $faker->numberBetween(2020, 2022),
        'start_month' => sprintf("%02d", $faker->numberBetween(1, 6)),
        'end_month' => sprintf("%02d", $faker->numberBetween(6, 12)),
        'details' => $faker->optional()->text(200),
    ];
});

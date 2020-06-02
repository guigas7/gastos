<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ExtypeSource;
use Faker\Generator as Faker;

$factory->define(ExtypeSource::class, function (Faker $faker) {
    return [
        'extype_id' => $faker->numberBetween(1, 17),
        'source_id' => $faker->numberBetween(1, 6),
        'default' => $faker->optional()->randomFloat(2),
        'year' => $faker->numberBetween(2019, 2021),
    ];
});
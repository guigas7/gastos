<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\IntypeSource;
use Faker\Generator as Faker;

$factory->define(IntypeSource::class, function (Faker $faker) {
    return [
        'intype_id' => $faker->numberBetween(1, 12),
        'source_id' => $faker->numberBetween(1, 6),
        'default' => $faker->randomFloat(2),
        'year' => $faker->numberBetween(2019, 2021),
    ];
});

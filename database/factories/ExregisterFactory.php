<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Exregister;
use Faker\Generator as Faker;

$factory->define(Exregister::class, function (Faker $faker) {
    return [
        'extype_source_id' => factory(\App\ExtypeSource::class),
        'month' => sprintf("%02d", $faker->numberBetween(1, 12)),
        'value' => $faker->randomFloat(2),
        'observations' => $faker->optional()->text(200),
    ];
});

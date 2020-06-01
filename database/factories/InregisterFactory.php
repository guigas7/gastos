<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Inregister;
use Faker\Generator as Faker;

$factory->define(Inregister::class, function (Faker $faker) {
    return [
        'intype_source_id' => factory(\App\IntypeSource::class),
        'month' => sprintf("%02d", $faker->numberBetween(1, 12)),
        'value' => $faker->randomFloat(2),
        'observations' => $faker->text(200),
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Extype;
use Faker\Generator as Faker;

$factory->define(Extype::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->text(200),
    ];
});

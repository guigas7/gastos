<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Month;
use Faker\Generator as Faker;

$factory->define(Month::class, function (Faker $faker) {
	return [
        'name' => $faker->word,
        'short' => $faker->text(5),
        'number' => sprintf("%02d", $faker->unique()->numberBetween(1, 12)),
    ];
});

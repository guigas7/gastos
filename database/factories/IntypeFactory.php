<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Intype;
use Faker\Generator as Faker;

$factory->define(Intype::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->text(200),
    ];
});

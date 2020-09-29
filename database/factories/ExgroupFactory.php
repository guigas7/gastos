<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Exgroup;
use Faker\Generator as Faker;

$factory->define(Exgroup::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->text(200),
    ];
});

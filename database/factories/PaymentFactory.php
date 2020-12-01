<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Payment;
use App\Payday;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
    	'payday_id' => factory(App\Payday::class),
        'year' => $faker->numberBetween(2017, 2022),
        'month_id' => $faker->numberBetween(1, 12),
    ];
});

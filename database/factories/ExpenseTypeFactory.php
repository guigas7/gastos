<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ExpenseType;
use Faker\Generator as Faker;

$factory->define(ExpenseType::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'source_id' => factory(App\Source::class),
        'description' => $faker->text(200),
        'default' => $faker->optional()->randomFloat(2),
    ];
});

$factory->afterCreating(App\ExpenseType::class, function ($holder, $faker) {
	$year = $faker->numberBetween(2017, 2022);
	for ($i = 1; $i <= 12; $i++) {
		Factory(App\Record::class)->create([
			'recordable_id' => $holder->id,
			'year' => $year,
			'month_id' => $i,
		]);
	}
});
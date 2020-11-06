<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\IncomeType;
use Faker\Generator as Faker;

$factory->define(IncomeType::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3),
        'source_id' => factory(App\Source::class),
        'description' => $faker->text(200),
    ];
});

$factory->afterCreating(App\IncomeType::class, function ($holder, $faker) {
	$year = $faker->numberBetween(2017, 2022);
	for ($i = 1; $i <= 12; $i++) {
		Factory(App\Record::class)
			->states('income')
			->create([
				'recordable_id' => $holder->id,
				'year' => $year,
				'month_id' => $i,
		]);
	}
});
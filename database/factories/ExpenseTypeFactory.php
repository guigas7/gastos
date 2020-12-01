<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ExpenseType;
use Faker\Generator as Faker;

$factory->define(ExpenseType::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3),
        'source_id' => factory(App\Source::class),
        'description' => $faker->text(200),
        'fixed' => $faker->boolean(50),
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

	if ($faker->boolean(90) && $holder->fixed == 1) {
		Factory(App\Payday::class)->create([
			'due_day' => $faker->numberBetween(1, 27),
			'expense_type_id' => $holder->id,
		]);
	}
});
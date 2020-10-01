<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Source;
use Faker\Generator as Faker;

$factory->define(Source::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(2),
        'income' => $faker->boolean(40),
    ];
});

$factory->afterCreating(App\Source::class, function ($source, $faker) {
	if ($source->income == 1) {
		factory(App\IncomeType::class, 5)->create([
			'source_id' => $source->id,
    	]);
	}
    factory(App\ExpenseType::class, 6)->create([
		'source_id' => $source->id,
    ]);

    factory(App\ExpenseGroup::class, 2)->create([
        'source_id' => $source->id,
    ]);
});

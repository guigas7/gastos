<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ExpenseGroup;
use Faker\Generator as Faker;

$factory->define(ExpenseGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->optional()->text(200),
        'source_id' => factory(App\Source::class),
    ];
});

$factory->afterCreating(App\ExpenseGroup::class, function ($group, $faker) {
	$expenses = array_values($group
		->source
		->ungroupedExpenses()
		->shuffle()
		->take($faker->numberBetween(2, 3))->all());
	$group
		->expenseTypes()
		->saveMany($expenses);
});
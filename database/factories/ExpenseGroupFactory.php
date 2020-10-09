<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ExpenseGroup;
use Faker\Generator as Faker;

$factory->define(ExpenseGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->optional()->text(200),
        'source_id' => factory(App\Source::class),
        'fixed' => $faker->boolean(50),
    ];
});

$factory->afterCreating(App\ExpenseGroup::class, function ($group, $faker) {
	$expensesWithSameType = array_values($group
		->source
		->ungroupedExpenses()
		->where('fixed', ($group->fixed == true ? true : false))
		->take($faker->numberBetween(2, 3))->all());
	$group
		->expenseTypes()
		->saveMany($expensesWithSameType);
});
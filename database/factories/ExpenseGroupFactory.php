<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ExpenseGroup;
use Faker\Generator as Faker;

$factory->define(ExpenseGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->optional()->text(200),
        'source_id' => factory(App\Source::class),
        'fixed' => $faker->boolean(30),
    ];
});

$factory->afterCreating(App\ExpenseGroup::class, function ($group, $faker) {
	$group
		->expenseTypes()
		->attach($group
			->source
			->ungroupedExpenses()
			->take($faker->numberBetween(2, 3))->pluck('id')->all()); // adds 2 or 3 expenses to the group
});

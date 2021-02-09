<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Payday;
use App\ExpenseType;
use App\Payment;
use Faker\Generator as Faker;

$factory->define(Payday::class, function (Faker $faker) {
    return [
        'expense_type_id' => factory(App\ExpenseType::class),
        'due_day' => sprintf("%02d", $faker->numberBetween(1, 27)),
    ];
});

$factory->afterCreating(App\Payday::class, function ($holder, $faker) {
    if ($faker->boolean(50)) {
        Factory(App\Payment::class)->create([
            'payday_id' => $holder->id,
        ]);
    }
});
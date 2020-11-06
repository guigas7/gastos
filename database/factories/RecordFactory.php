<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Record;
use Faker\Generator as Faker;

$factory->define(Record::class, function (Faker $faker) {
    return [
        'recordable_id' => factory(App\ExpenseType::class),
        'recordable_type' => function (array $record) {
            return App\ExpenseType::find($record['recordable_id'])->getValueType();
        },
        'year' => $faker->numberBetween(2017, 2022),
        'month_id' => $faker->numberBetween(1, 12),
        'value' => $faker->randomFloat(2),
        'description' => $faker->optional()->text(200),
    ];
});

$factory->state(App\Record::class, 'income', function ($faker) {
    return [
        'recordable_id' => factory(App\IncomeType::class),
        'recordable_type' => function (array $record) {
            return App\IncomeType::find($record['recordable_id'])->getValueType();
        },
    ];
});

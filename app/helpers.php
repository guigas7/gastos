<?php

use App\Month;

function nextYear()
{
	return now()->format('Y') + 1;
}

function yearRange()
{
	return range(2017, nextYear());
}

function thisMonth()
{
	return Month::where('number', now()->format('m'))->first();
}

function thisYear()
{
	return now()->format('Y');
}

// Expecting $types to be a return of expensesAt or incomesAt
function monthlySum($types)
{
	return number_format($types->map(
		function ($type) {
			return $type->records->first();
		})
		->pluck('value')
		->sum(), 2, ',', '.');
}
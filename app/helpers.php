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
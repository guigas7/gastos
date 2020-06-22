<?php

function nextYear()
{
	return now()->format('Y') + 1;
}

function yearRange()
{
	return range(2017, nextYear());
}
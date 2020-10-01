<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Month;
use App\IncomeType;
use App\Traits\RecordsMonthlyValue;
use App\Traits\Sluggable;
use Illuminate\Support\Str; // Sluggable


class IncomeType extends Model
{
	use RecordsMonthlyValue, Sluggable;

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}


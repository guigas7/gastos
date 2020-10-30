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

    protected $appends = ['endPoint'];

    public function getEndPointAttribute()
    {
        return route('income.delete', $this->slug);
    }
}


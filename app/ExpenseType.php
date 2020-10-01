<?php

namespace App;
use App\Month;
use App\ExpenseType;
use App\Traits\RecordsMonthlyValue;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Sluggable

class ExpenseType extends Model
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

    public function expenseGroups()
    {
        return $this->belongsToMany('App\ExpenseGroups');
    }
}

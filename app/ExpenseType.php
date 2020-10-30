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

    protected $appends = ['endPoint'];

    public function expenseGroup()
    {
        return $this->belongsTo('App\ExpenseGroup', 'expense_group_id');
    }

    public function getEndPointAttribute()
    {
        return route('expense.delete', $this->slug);
    }
}

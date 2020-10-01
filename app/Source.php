<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Intype;
use App\Extype;
use App\Traits\Sluggable;
use Illuminate\Support\Str; // Sluggable

class Source extends Model
{
    use Sluggable;

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    // protected $appends = ['fixedExpenses', 'variableExpenses'];

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
        return $this->hasMany('App\ExpenseGroup');
    }

    public function incomeTypes()
    {
        return $this->hasMany('App\IncomeType');
    }

    public function expenseTypes()
    {
        return $this->hasMany('App\ExpenseType');
    }

    public function getFixedExpensesAttribute()
    {
        return $this->expenseTypes()->where('default', "!=", null)->get();
    }

    public function getVariableExpensesAttribute()
    {
        return $this->expenseTypes()->where('default', null)->get();
    }

    public function ungroupedExpenses()
    {
        $inGroup = collect();
        foreach ($this->expenseGroups as $group) {
            $inGroup = $inGroup->merge($group->expenseTypes);
        }
        return $this->expenseTypes->diff($inGroup)->values();
    }

    public function allIncomesAt($year, Month $month = null)
    {
        if (empty($month)) {
            return $this->
                incomeTypes()
                ->with('records')
                ->whereHas('records', function ($record) use ($year) {
                    $record
                        ->where('year', $year);
                })->get();
        } else {
            return $this->
                incomeTypes()
                ->with('records')
                ->whereHas('records', function ($record) use ($year, $month) {
                    $record
                        ->where('year', $year)
                        ->where('month_id', $month->id);
                })->get();
        }
    }

    public function allExpensesAt($year, Month $month = null)
    {
        if (empty($month)) {
            return $this->
                ExpenseTypes()
                ->with(['records' => function($query) use ($year) {
                        $query->where('year', $year);
                }])->get();
        } else {
            return $this->
                ExpenseTypes()
                ->with(['records' => function($query) use ($year, $month) {
                        $query->where('year', $year)
                            ->where('month_id', $month->id);
                }])->get();
        }
    }
}
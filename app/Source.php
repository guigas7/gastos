<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\IncomeType;
use App\ExpenseType;
use App\Month;
use App\Record;
use App\Traits\Sluggable;
use App\Traits\HasExpense;
use App\Traits\PrintsName;
use Illuminate\Support\Str; // Sluggable

class Source extends Model
{
    use Sluggable, PrintsName, HasExpense;

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

    public function ExpenseGroups()
    {
        return $this->hasMany('App\ExpenseGroup');
    }

    public function ExpenseGroupsWithExpenses()
    {
        return $this->hasMany('App\ExpenseGroup')->with('expenseTypes');
    }

    public function incomeTypes()
    {
        return $this->hasMany('App\IncomeType');
    }

    public function expenseTypes()
    {
        return $this->hasMany('App\ExpenseType');
    }

    public function ungroupedExpenses($fixed = null)
    {
        $groups = $this->ExpenseGroups;

        $inGroup = collect();
        foreach ($groups as $group) {
            $inGroup = $inGroup->merge($group->expenseTypes);
        }

        if ($fixed === null) {
            return $this->ExpenseTypes->diff($inGroup)->values();
        } elseif ($fixed == "fixed") {
            return $this->fixedExpenseTypes->diff($inGroup)->values();
        } else {
            return $this->variableExpenseTypes->diff($inGroup)->values();
        }
    }

    public function incomesAt($year, Month $month = null, $only = null)
    {
        // Query to eager load all records from the selected period
        $callback = function($recordQuery) use ($year, $month) {
            $recordQuery = $recordQuery->where('year', $year);
            if (!empty($month)) {
                $recordQuery = $recordQuery->where('month_id', $month->id);
            }
            return $recordQuery;
        };

        // Return only expenses with records in the selected period
        $typeQuery = $this->incomeTypes();
        if ($only === "only") {
            $typeQuery = $typeQuery->whereHas('records', $callback);
        }

        return $typeQuery
            ->with(['records' => $callback])
            ->get();
    }
}

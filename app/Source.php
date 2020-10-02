<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Intype;
use App\Extype;
use App\Month;
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

    public function expenseGroupsWithExpenses()
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

    public function expensesAt($year, Month $month = null, $only = null, $fixed = null)
    {
        // Query to eager load all records from the selected period
        $callback = function($recordQuery) use ($year, $month) {
            $recordQuery = $recordQuery->where('year', $year);
            if (!empty($month)) {
                $recordQuery = $recordQuery->where('month_id', $month->id);
            }
            return $recordQuery;
        };

        // Only fixed expenses, only variable expenses or both (aka, no filter)
        $typeQuery = $this->expenseTypes();
        if ($fixed === "fixed") {
            $typeQuery = $typeQuery->where('default', "!=", null);
        } elseif ($fixed === "variable") {
            $typeQuery = $typeQuery->where('default', "=", null);
        }

        // Return only expenses with records in the selected period
        if ($only === "only") {
            $typeQuery = $typeQuery->whereHas('records', $callback);
        }

        return $typeQuery
            ->with(['records' => $callback])
            ->get();
    }

    public function createRecordsIfNotCreated($year)
    {
        $typesWithNoRecords = expenseTypesToCreateIn($year);
        if ($typesWithNoRecords->count() > 0) {
            $months = Month::all();
            foreach ($typesWithNoRecords as $type) {
                $records = [];
                $defaultValue = ($type->default == null ? 0 : $type->default);
                foreach ($months as $month) {
                    array_push($records, new App\record([
                        'year' => $year,
                        'month_id' => $month->id,
                        'value' => $defaultValue,
                    ]));
                }
                $type->records()->saveMany($records);
            }
        }

        if ($this->income == 0) return;

        $typesWithNoRecords = incomeTypesToCreateIn($year);

        if ($typesWithNoRecords->count() > 0) {
            $months = Month::all();
            foreach ($typesWithNoRecords as $type) {
                $records = [];
                foreach ($months as $month) {
                    array_push($records, new App\record([
                        'year' => $year,
                        'month_id' => $month->id,
                        'value' => 0,
                    ]));
                }
                $type->records()->saveMany($records);
            }
        }
    }

    public function expenseTypesToCreateIn($year)
    {
        $typesWithRecords = $source->expensesAt($year, null, "only")->pluck('id');
        $allTypes = $source->expenseTypes->pluck('id');
        return $allTypes->diff($typesWithRecords);
    }

    public function incomeTypesToCreateIn($year)
    {
        $typesWithRecords = $source->incomesAt($year, null, "only")->pluck('id');
        $allTypes = $source->incomeTypes->pluck('id');
        return $allTypes->diff($typesWithRecords);
    }
}
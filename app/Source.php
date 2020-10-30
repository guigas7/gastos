<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Intype;
use App\Extype;
use App\Month;
use App\Record;
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

    public function getFixedExpenseTypesAttribute()
    {
        return $this->expenseTypes()->where('fixed', true)->get();
    }

    public function getVariableExpenseTypesAttribute()
    {
        return $this->expenseTypes()->where('fixed', false)->get();
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
            $typeQuery = $typeQuery->where('fixed', true);
        } elseif ($fixed === "variable") {
            $typeQuery = $typeQuery->where('fixed', false);
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
        $typesWithNoRecords = $this->expenseTypesToCreateIn($year);
        if ($typesWithNoRecords->count() > 0) {
            $months = Month::all();
            foreach ($typesWithNoRecords as $id) {
                $type = ExpenseType::find($id);
                $records = [];
                foreach ($months as $month) {
                    array_push($records, new Record([
                        'year' => $year,
                        'month_id' => $month->id,
                    ]));
                }
                $type->records()->saveMany($records);
            }
        }

        if ($this->income == 0) return;

        $typesWithNoRecords = $this->incomeTypesToCreateIn($year);

        if ($typesWithNoRecords->count() > 0) {
            $months = Month::all();
            foreach ($typesWithNoRecords as $id) {
                $type = IncomeType::find($id);
                $records = [];
                foreach ($months as $month) {
                    array_push($records, new Record([
                        'year' => $year,
                        'month_id' => $month->id,
                    ]));
                }
                $type->records()->saveMany($records);
            }
        }
    }

    public function expenseTypesToCreateIn($year)
    {
        $typesWithRecords = $this->expensesAt($year, null, "only")->pluck('id');
        $allTypes = $this->expenseTypes->pluck('id');
        return $allTypes->diff($typesWithRecords);
    }

    public function incomeTypesToCreateIn($year)
    {
        $typesWithRecords = $this->incomesAt($year, null, "only")->pluck('id');
        $allTypes = $this->incomeTypes->pluck('id');
        return $allTypes->diff($typesWithRecords);
    }

    public function getLimitedName30Attribute()
    {
        if (strlen($this->name) <= 30) return $this->name;
        return Str::limit($this->name, 30); 
    }
}

<?php

namespace App\Traits;
use Illuminate\Support\Str;
use App\IncomeType;
use App\ExpenseType;
use App\Month;
use App\Record;

trait HasExpense
{
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
            ->with(['records' => $callback, 'paydays'])
            ->get();
    }

    public function getFixedExpenseTypesAttribute()
    {
        return $this->expenseTypes()->where('fixed', true)->get();
    }

    public function getVariableExpenseTypesAttribute()
    {
        return $this->expenseTypes()->where('fixed', false)->get();
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

        if ($this->income === 0) return;

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

    public function expenseSumAt($year, Month $month = null, $only = null, $fixed = null)
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

        $expenses = $typeQuery
            ->with(['records' => $callback])
            ->get();

        $sum = 0;
        foreach ($expenses as $expense) {
        	$sum += $expense->records->pluck('value')->sum();
        }
        return $sum;
    }
}

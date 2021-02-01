<?php

namespace App;
use App\Month;
use App\ExpenseType;
use App\Payday;
use App\Traits\RecordsMonthlyValue;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App\Traits\PrintsName;
use Illuminate\Support\Str; // Sluggable

class ExpenseType extends Model
{
	use RecordsMonthlyValue, Sluggable, PrintsName;

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

    /**
     * Get the paydays for the Expense type.
     */
    public function paydays()
    {
        return $this->hasMany('App\Payday');
    }

    public function paymentsAt($year, Month $month)
    {
        // Query to eager load all records from the selected period
        $callback = function($periodQuery) use ($year, $month) {
            $periodQuery = $periodQuery->where('year', $year);
            if (!empty($month)) {
                    $periodQuery = $periodQuery->where('month_id', $month->id);
            }
            return $periodQuery;
        };

        return $this->paydays()->with([
            'payments' => $callback
        ])->get() # For all paydays of $expenseType, appends payments from the selected $year and $month
        ->map->only('payments') # Ignores payday data and keeps only payments
        ->flatten()->all(); # Keeps an array of all registered payments
    }

    public function paydaysWithPaymentsAt($year, Month $month, $only = null)
    {
        // Query to eager load all records from the selected period
        $callback = function($periodQuery) use ($year, $month) {
            $periodQuery = $periodQuery->where('year', $year);
            if (!empty($month)) {
                    $periodQuery = $periodQuery->where('month_id', $month->id);
            }
            return $periodQuery;
        };

        $query = $this->paydays();
        // Return only expenses with records in the selected period
        if ($only === "only") {
            $query = $query->whereHas('payments', $callback);
        }

        return $query->with([
            'payments' => $callback
        ])->get();
    }
}

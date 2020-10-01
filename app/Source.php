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

    public function fixedExpenses()
    {
        return $this->expenseTypes()->where('default', "!=", null)->get();
    }

    public function variableExpenses()
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
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Payment;
use App\ExpenseType;

class Payday extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    
    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    /**
     * Get the Expense type that has the payday.
     */
    public function expenseType()
    {
        return $this->belongsTo('App\ExpenseType');
    }
}

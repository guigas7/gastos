<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseGroup extends Model
{

    protected $guarded = [];

    public function source()
    {
        return $this->belongsTo(
            'App\Source',
            'source_id',
            'id',
        );
    }

    public function expenseTypes()
    {
        return $this->hasMany('App\ExpenseType', 'expense_group_id');
    }
}

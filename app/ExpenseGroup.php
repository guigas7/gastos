<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseGroup extends Model
{
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
        return $this->belongsToMany('App\ExpenseType');
    }
}

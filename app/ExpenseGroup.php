<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sluggable;

class ExpenseGroup extends Model
{
    use Sluggable;

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

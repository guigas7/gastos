<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sluggable;
use App\Traits\HasExpense;
use App\Traits\PrintsName;
use App\Extype;
use App\Month;
use Illuminate\Support\Str; // Sluggable

class ExpenseGroup extends Model
{
    use Sluggable, PrintsName, HasExpense;

    protected $guarded = [];

    protected $appends = ['endPoint'];

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

    public function expenseString()
    {
        return $this->expenseTypes->pluck('name')->implode(", ");
    }

    public function getEndPointAttribute()
    {
        return route('exgroup.delete', $this->slug);
    }
}

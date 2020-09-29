<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exgroup extends Model
{
    public function source()
    {
        return $this->belongsTo('App\Source');
    }

    public function extypes()
    {
        return $this->belongsToMany(
            'App\Extype',
            'exgroup_extype',
            'exgroup_id',
            'extype_id',
        )->withPivot(
            'name',
            'description',
        )->withTimestamps();
    }

    protected $guarded = [];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{

	protected $guarded = [];

	protected $appends = ['endPoint'];

    public function recordable()
    {
        return $this->morphTo();
    }

    public function getEndPointAttribute()
    {
        return route('record.update', $this->id);
    }
}

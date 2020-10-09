<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{

	protected $guarded = [];

    public function recordable()
    {
        return $this->morphTo();
    }
}

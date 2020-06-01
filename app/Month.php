<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public $timestamps = false;
}

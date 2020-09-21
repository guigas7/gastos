<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Source;
use App\Intype;

class SourceIntypePeriod extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    public $timestamps = false;

   	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['intype_id', 'source_id'];

    public function intype()
    {
        return $this->belongsTo(Intype::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}

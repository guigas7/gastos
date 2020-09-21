<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Source;
use App\Extype;

class SourceExtypePeriod extends Pivot
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
    protected $guarded = ['extype_id', 'source_id'];

    public function extype()
    {
        return $this->belongsTo(Extype::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}

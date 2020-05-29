<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Source;
use App\Intype;

class ExtypeSource extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

   	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['intype_id', 'source_id'];

    public function intypes()
    {
        return $this->belongsTo(Intype::class);
    }

    public function sources()
    {
        return $this->belongsTo(Source:class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\IntypeSource;

class Inregister extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['intype_source_id'];
    
    public function intypeSource()
    {
        return $this->belongsTo('App\IntypeSource', 'intype_source_id');
    }
 
    public function source()
    {
        return $this->intypeSource->source;
    }

    public function intype()
    {
        return $this->intypeSource->intype;
    }
}

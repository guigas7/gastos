<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ExtypeSource;

class Exregister extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['extype_source_id'];
    
    public function ExtypeSource()
    {
        return $this->belongsTo('App\ExtypeSource', 'extype_source_id');
    }

}

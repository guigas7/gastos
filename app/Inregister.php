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

    public function Source()
    {
        return $this->hasOneThrough('App\IntypeSource', 'App\Source');
    }

    public function Intype()
    {
        return $this->hasOneThrough('App\IntypeSource', 'App\Intype');
    }
}

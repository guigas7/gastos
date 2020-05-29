<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Intype;
use App\Extype;

class Source extends Model
{
	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function patientsPr()
    {
        return $this->hasMany('App\Prpatient', 'hospital_id');
    }

    public function intypes()
    {
        return $this->belongsToMany(Source:class)
            ->using('App\IntypeSource')->withPivot([
                'default',
                'year',
            ]);
    }

    public function extypes()
    {
        return $this->belongsToMany(Source:class)
            ->using('App\ExtypeSource')->withPivot([
                'default',
                'year',
            ]);
    }
}


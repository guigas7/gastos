<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intype extends Model
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

    public function sources()
    {
        return $this->belongsToMany(Source:class)
            ->using('App\IntypeSource')->withPivot([
                'default',
                'year',
            ]);
    }
}

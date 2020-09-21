<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        return $this->belongsToMany(
            'App\Source',
            'intype_source',
            'intype_id',
            'source_id',
        )->withPivot(
            'year',
            'month',
            'observations'
        );
    }

    public function sourcesPeriod()
    {
        return $this->belongsToMany(
            'App\Source',
            'source_intype_period',
            'intype_id',
            'source_id',
        )->withPivot(
            'start_year',
            'start_month',
            'end_year',
            'end_month',
            'details'
        );
    }

    public static function boot()
    {
        parent::boot();
 
        static::creating(function ($type) {
            if (!is_null($type->name)) {
                $type->slug = Str::slug($type->name);
     
                $latestSlug =
                Intype::whereRaw("slug RLIKE '^{$type->slug}(--[0-9]*)?$'")
                    ->latest('slug')
                    ->pluck('slug');
                if ($latestSlug->first() != null) {
                    $pieces = explode('--', $latestSlug->first());
                    if (count($pieces) == 1) { // first repetition
                        $type->slug .= '--' . '1';
                    } else {
                        $number = intval(end($pieces));
                        $type->slug .= '--' . ($number + 1);
                    }
                } 
            }
        });
 
        static::updating(function ($type) {
            $oldtype = Intype::findOrFail($type->id);
            if (is_null($type->name)) {
                $type->slug = null;
            } else {
                if ($oldtype->name != $type->name) { // se o nome foi alterado, então altera slug também
                    $type->slug = Str::slug($type->name);
    
                    $latestSlug =
                    Intype::whereRaw("slug RLIKE '^{$type->slug}(--[0-9]*)?$'")
                        ->latest('slug')
                        ->pluck('slug');
                    if ($latestSlug->first() != null) {
                        $pieces = explode('--', $latestSlug->first());
                        if (count($pieces) == 1) { // first repetition
                            $type->slug .= '--' . '1';
                        } else {
                            $number = intval(end($pieces));
                            $type->slug .= '--' . ($number + 1);
                        }
                    } 
                }
            }
        });
    }
}

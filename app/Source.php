<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Intype;
use App\Extype;
use Illuminate\Support\Str;

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

    public function intypes()
    {
        return $this->belongsToMany(
            'App\Intype',
            'intype_source',
            'source_id',
            'intype_id',
        )->withPivot('year');
    }

    public function extypes()
    {
        return $this->belongsToMany(
            'App\Extype',
            'extype_source',
            'source_id',
            'extype_id',
        )->withPivot('default','year');
    }

    public function extypeSources()
    {
        return $this->hasMany('App\ExtypeSource');
    }

    public function intypeSources()
    {
        return $this->hasMany('App\IntypeSource');
    }

    public static function boot()
    {
        parent::boot();
 
        static::creating(function ($source) {
            if (!is_null($source->name)) {
                $source->slug = Str::slug($source->name);
     
                $latestSlug =
                Source::whereRaw("slug RLIKE '^{$source->slug}(--[0-9]*)?$'")
                    ->latest('slug')
                    ->pluck('slug');
                if ($latestSlug->first() != null) {
                    $pieces = explode('--', $latestSlug->first());
                    if (count($pieces) == 1) { // first repetition
                        $source->slug .= '--' . '1';
                    } else {
                        $number = intval(end($pieces));
                        $source->slug .= '--' . ($number + 1);
                    }
                } 
            }
        });
 
        static::updating(function ($source) {
            $oldsource = Source::findOrFail($source->id);
            if (is_null($source->name)) {
                $source->slug = null;
            } else {
                if ($oldsource->name != $source->name) { // se o nome foi alterado, então altera slug também
                    $source->slug = Str::slug($source->name);
    
                    $latestSlug =
                    Source::whereRaw("slug RLIKE '^{$source->slug}(--[0-9]*)?$'")
                        ->latest('slug')
                        ->pluck('slug');
                    if ($latestSlug->first() != null) {
                        $pieces = explode('--', $latestSlug->first());
                        if (count($pieces) == 1) { // first repetition
                            $source->slug .= '--' . '1';
                        } else {
                            $number = intval(end($pieces));
                            $source->slug .= '--' . ($number + 1);
                        }
                    } 
                }
            }
        });
	}
}


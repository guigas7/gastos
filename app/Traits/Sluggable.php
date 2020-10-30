<?php

namespace App\Traits;
use Illuminate\Support\Str;

trait Sluggable
{
    protected static function bootSluggable()
    {
        static::creating(function ($model) {
            if (!is_null($model->name)) {
                $model->slug = Str::slug($model->name);
     
                $latestSlug =
                get_class($model)::whereRaw("slug RLIKE '^{$model->slug}(--[0-9]*)?$'")
                    ->latest('slug')
                    ->pluck('slug');
                if ($latestSlug->first() != null) {
                    $pieces = explode('--', $latestSlug->first());
                    if (count($pieces) == 1) { // first repetition
                        $model->slug .= '--' . '1';
                    } else {
                        $number = intval(end($pieces));
                        $model->slug .= '--' . ($number + 1);
                    }
                } 
            }
        });
 
        static::updating(function ($model) {
            $oldmodel = get_class($model)::findOrFail($model->id);
            if (is_null($model->name)) {
                $model->slug = null;
            } else {
                if ($oldmodel->name != $model->name) { // se o nome foi alterado, então altera slug também
                    $model->slug = Str::slug($model->name);
    
                    $latestSlug =
                    get_class($model)::whereRaw("slug RLIKE '^{$model->slug}(--[0-9]*)?$'")
                        ->latest('slug')
                        ->pluck('slug');
                    if ($latestSlug->first() != null) {
                        $pieces = explode('--', $latestSlug->first());
                        if (count($pieces) == 1) { // first repetition
                            $model->slug .= '--' . '1';
                        } else {
                            $number = intval(end($pieces));
                            $model->slug .= '--' . ($number + 1);
                        }
                    } 
                }
            }
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

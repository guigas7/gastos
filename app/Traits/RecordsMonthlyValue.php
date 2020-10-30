<?php

namespace App\Traits;

trait RecordsMonthlyValue
{

    public static function bootRecordsMonthlyValue()
    {
        // Delete associated images if they exist.
        static::deleting(function($model) {
            $model->records()->delete();
        });
    }

    /**
     * Makes a new record for the model.
     *
     * @param decimal $value
     * @param string $description
     */
    protected function recordValue($value, $description)
    {
        $month = session('month', thisMonth());
        $year = session('year', thisYear());
        $this->records()->create([
            'value' => $value,
            'description' => $description,
            'recordable_type' => $this->getValueType(),
            'month' => $month,
            'year' => $year
        ]);
    }

    /**
     * Fetch the activity relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function records()
    {
        return $this->morphMany('App\Record', 'recordable');
    }

    public function source()
    {
        return $this->belongsTo(
            'App\Source',
            'source_id',
            'id',
        );
    }

    /**
     * Determine the value type.
     *
     * @return string
     */
    public function getValueType()
    {
        return get_class($this);
    }
}

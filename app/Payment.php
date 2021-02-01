<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Payday;

class Payment extends Model
{
	protected $guarded = [];
	    
	/**
     * Get the payday that has the Payment.
     */
    public function payday()
    {
        return $this->belongsTo('App\Payday');
    }
}

<?php

use Illuminate\Database\Seeder;

class ExtypeSourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$source_ids = range(1, 6);
    	$extype_ids = range(1, 17);
    	$years = range(2019,2021);
    	foreach ($source_ids as $source) {
    		foreach ($extype_ids as $type) {
    			foreach ($years as $year) {
	    	factory('App\ExtypeSource')->create([
	    		'source_id' => $source,
	    		'extype_id' => $type,
	    		'year' => $year,
	    	]);
    	}
    }
}

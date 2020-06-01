<?php

use Illuminate\Database\Seeder;

class IntypeSourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$source_ids = range(1, 6);
    	$intype_ids = range(1, 12);
    	$years = range(2019,2021);
    	foreach ($years as $year) {
    	    foreach ($source_ids as $source) {
    		    foreach ($intype_ids as $type) {
	    	        factory('App\IntypeSource')->create([
	    		        'source_id' => $source,
	    		        'intype_id' => $type,
	    		        'year' => $year,
	    	        ]);
    	        }
            }
        }
    }
}

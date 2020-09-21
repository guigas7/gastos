<?php

use Illuminate\Database\Seeder;

class SourceExtypePeriodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start_month = "01";
        $end_month = "12";
        $start_year = "2019";
        $end_year = "2021";
    	$source_ids = range(1, 6);
    	$extype_ids = range(1, 17);
	    foreach ($source_ids as $source) {
		    foreach ($extype_ids as $type) {
    	        factory('App\SourceExtypePeriod')->create([
    		        'source_id' => $source,
    		        'extype_id' => $type,
    		        'start_year' => $start_year,
                    'start_month' => $start_month,
    		        'end_year' => $end_year,
                    'end_month' => $end_month,
    	        ]);
            }
        }
    }
}

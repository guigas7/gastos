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
        $months = [
            "01",
            "02",
            "03",
            "04",
            "05",
            "06",
            "07",
            "08",
            "09",
            "10",
            "11",
            "12",
        ];

    	$source_ids = range(1, 6);
    	$extype_ids = range(1, 17);
    	$years = array_map("strval", range(2019,2021));
    	foreach ($years as $year) {
    	    foreach ($source_ids as $source) {
    		    foreach ($extype_ids as $type) {
                    foreach ($months as $month) {
    	    	        factory('App\ExtypeSource')->create([
    	    		        'source_id' => $source,
    	    		        'extype_id' => $type,
    	    		        'year' => $year,
                            'month' => $month,
    	    	        ]);
                    }
    	        }
            }
        }
    }
}

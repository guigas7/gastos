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
    	$intype_ids = range(1, 12);
    	$years = array_map("strval", range(2019,2021));
    	foreach ($years as $year) {
    	    foreach ($source_ids as $source) {
    		    foreach ($intype_ids as $type) {
                    foreach ($months as $month) {
    	    	        factory('App\IntypeSource')->create([
    	    		        'source_id' => $source,
    	    		        'intype_id' => $type,
    	    		        'year' => $year,
                            'month' => $month,
    	    	        ]);
                    }
    	        }
            }
        }
    }
}

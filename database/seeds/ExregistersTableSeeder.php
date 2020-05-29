<?php

use Illuminate\Database\Seeder;
use App\Extype;
use App\Source;

class ExregistersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$types = Extype::all();
    	$types = Extype::all();
    	foreach ($names as $name) {
	    	factory('App\Extype')->create([
	    		'name' => $name
	    	]);
    	}
    }
}

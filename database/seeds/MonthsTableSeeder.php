<?php

use Illuminate\Database\Seeder;

class MonthsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	$names = [
    		'Janeiro',
    		'Fevereiro',
    		'Março',
    		'Abril',
    		'Maio',
    		'Junho',
    		'Julho',
    		'Agosto',
    		'Setembro',
    		'Outubro',
    		'Novembro',
    		'Dezembro',
    	];
    	
    	$numbers = [
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

    	foreach ($names as $i => $name) {
	    	factory('App\Source')->create([
	    		'name' => $name,
	    		'number' => $numbers[$i]
	    	]);
    	}
    }
}

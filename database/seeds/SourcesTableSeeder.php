<?php

use Illuminate\Database\Seeder;

class SourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$names = [
    		'Cepeti',
    		'Cuidados Intensivos do Paraná (jur)',
    		'Cuidados Intensivos do Paraná (fis)',
    		'Tecnologia',
    		'Comunicação',
    		'Pesquisa'
    	];
    	
    	foreach ($names as $name) {
	    	factory('App\Source')->create([
	    		'name' => $name
	    	]);
    	}
    }
}

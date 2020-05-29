<?php

use Illuminate\Database\Seeder;

class IntypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
    		'INC',
			'Marcelino',
			'Vita Batel',
			'Nações',
			'Cajuru',
			'Santa casa',
			'AMIB',
			'Redentor PG II, III, IV',
			'CENTRO DE PESQUISAS',
			'NF (Dra Rosângela)',
            'Resgate Aplicação',
			'Outros',
    	];
    	
    	foreach ($names as $name) {
	    	factory('App\Intype')->create([
	    		'name' => $name
	    	]);
    	}
    }
}

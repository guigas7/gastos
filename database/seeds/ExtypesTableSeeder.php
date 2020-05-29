<?php

use Illuminate\Database\Seeder;

class ExtypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
			'Beneficios vt/va(20)'
			'Folha de Pagamento(05)'
			'Água (Deb Aut PJ Dra)(13)'
			'Alugel (Pago PJ Dra)(18)'
			'luz (Deb Aut PJ Dra) (19)'
			'Telefone(05/09)'
			'Alarme(21)'
			'Contabilidade(06)'
			'Internet(01)'
			'Site(extreme)(10)'
			'TI(Kody)'
			'TV a cabo(05)'
			'Arquivo(doc service)'
			'Motoboy'
			'ISS(20)'
			'IR(30)'
			'PIS/Cofins/CSLL'
    	];
    	
    	foreach ($names as $name) {
	    	factory('App\Extype')->create([
	    		'name' => $name
	    	]);
    	}
    }
}

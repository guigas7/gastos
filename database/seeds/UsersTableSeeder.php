<?php 

use Illuminate\Database\Seeder;

Class UsersTableSeeder extends Seeder {

	public function run()
	{
		factory('App\User', 5)->create();
	}
}
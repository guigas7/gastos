<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	protected $toTruncate = ['users'];
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		foreach ($toTruncate as $table) {
			DB::table($table)->truncate();
		}

        $this->call(UsersTableSeeder::class);
    }
}

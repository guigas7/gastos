<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	protected $toTruncate = [
        'users',
        'sources',
        'months',
        'intypes',
        'extypes'
    ];
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
        $this->call(SourcesTableSeeder::class);
        $this->call(MonthsTableSeeder::class);
        $this->call(IntypesTableSeeder::class);
        $this->call(ExtypesTableSeeder::class);
    }
}

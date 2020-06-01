<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $toTruncate = [
            'users',
            'sources',
            'months',
            'intypes',
            'extypes'
        ];

        Schema::disableForeignKeyConstraints();
		foreach ($toTruncate as $table) {
			DB::table($table)->truncate();
		}
        Schema::enableForeignKeyConstraints();

        $this->call(UsersTableSeeder::class);
        $this->call(SourcesTableSeeder::class);
        $this->call(MonthsTableSeeder::class);
        $this->call(IntypesTableSeeder::class);
        $this->call(ExtypesTableSeeder::class);
        $this->call(IntypeSourcesTableSeeder::class);
        $this->call(ExtypeSourcesTableSeeder::class);
        $this->call(InregistersTableSeeder::class);
        $this->call(ExregistersTableSeeder::class);
    }
}

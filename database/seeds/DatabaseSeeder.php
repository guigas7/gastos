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
            'sources',
            'income_types',
            'expense_groups',
            'expense_types',
            'records',
            'payments',
            'paydays',
            'months',
        ];

        Schema::disableForeignKeyConstraints();
		foreach ($toTruncate as $table) {
			DB::table($table)->truncate();
		}
        Schema::enableForeignKeyConstraints();

        $this->call(UsersTableSeeder::class);
        $this->call(MonthsTableSeeder::class);
        $this->call(SourcesTableSeeder::class);
    }
}

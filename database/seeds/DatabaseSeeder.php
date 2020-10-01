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
            'expense_types',
            'records',
            'months',
            'expense_groups',
            'expense_group_expense_type',
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

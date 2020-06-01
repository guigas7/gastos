<?php

use Illuminate\Database\Seeder;
use App\IntypeSource;

class InregistersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $months = [
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

        $ids = IntypeSource::all()->pluck('id')->toArray();

        foreach ($ids as $id) {
            foreach ($months as $month) {
                factory('App\Inregister')->create([
                    'intype_source_id' => $id,
                    'month' => $month,
                ]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            ['name' => 'Warszawa'],
            ['name' => 'Poznań'],
            ['name' => 'Wrocław'],
            ['name' => 'Gdańsk'],
            ['name' => 'Rzeszów'],
            ['name' => 'Bydgoszcz'],
            ['name' => 'Sandomierz'],
            ['name' => 'Kielce'],
            ['name' => 'Katowice'],
            ['name' => 'Krosno']
        ]);
    }
}

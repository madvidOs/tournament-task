<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        //fill division A
        DB::table('division_teams')->insert([
            'id_division' => 1,
            'name' => 'A'
        ]);
        DB::table('division_teams')->insert([
            'id_division' => 1,
            'name' => 'B'
        ]);
        DB::table('division_teams')->insert([
            'id_division' => 1,
            'name' => 'C'
        ]);
        DB::table('division_teams')->insert([
            'id_division' => 1,
            'name' => 'D'
        ]);
        DB::table('division_teams')->insert([
            'id_division' => 1,
            'name' => 'E'
        ]);
        DB::table('division_teams')->insert([
            'id_division' => 1,
            'name' => 'F'
        ]);
        DB::table('division_teams')->insert([
            'id_division' => 1,
            'name' => 'G'
        ]);
        DB::table('division_teams')->insert([
            'id_division' => 1,
            'name' => 'H'
        ]);

        //fill division B
        DB::table('division_teams')->insert([
            'id_division' => 2,
            'name' => 'I'
        ]);
        DB::table('division_teams')->insert([
            'id_division' => 2,
            'name' => 'J'
        ]);    
        DB::table('division_teams')->insert([
            'id_division' => 2,
            'name' => 'K'
        ]);
        DB::table('division_teams')->insert([
            'id_division' => 2,
            'name' => 'L'
        ]);
        DB::table('division_teams')->insert([
            'id_division' => 2,
            'name' => 'M'
        ]);
        DB::table('division_teams')->insert([
            'id_division' => 2,
            'name' => 'N'
        ]);
        DB::table('division_teams')->insert([
            'id_division' => 2,
            'name' => 'O'
        ]);
        DB::table('division_teams')->insert([
            'id_division' => 2,
            'name' => 'P'
        ]);
    }
}

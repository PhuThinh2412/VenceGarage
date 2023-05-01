<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParkingLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('parking_levels')->insert([
            'name' => 'B1',
            'capacity' => 100
        ]);

        // \DB::table('parking_levels')->insert([
        //     'name' => 'B2',
        //     'capacity' => 90
        // ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \DB::table('vehicles_type')->insert([
            'type_name' => 'Car'
        ]);
        \DB::table('vehicles_type')->insert([
            'type_name' => 'Motorbike'
        ]);
    }
}

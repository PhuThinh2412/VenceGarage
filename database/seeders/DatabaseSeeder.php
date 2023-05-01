<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PharIo\Version\Version;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            VehicleTypeSeeder::class,
            ParkingLevelSeeder::class,
            ParkingSpaceSeeder::class,
        ]);
    }
}

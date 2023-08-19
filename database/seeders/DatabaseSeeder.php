<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            WordSeeder::class,
            WordChangeStatusSeeder::class,
            AdminTableSeeder::class,
            UserTableSeeder::class,
            CarTypesSeeder::class,
            CarMakeAndModelSeeder::class,
            ServiceLocationsSeeder::class,
            TimeZonesSeeder::class,
            VehicleTypesSeeder::class,
            SettingOtpSeeder::class,
            SosSeeder::class,
            ZoneSeeder::class,
            CompaniesTableSeeder::class,
            ZoneBoundSeeder::class,
            ZoneTypesSeeder::class,
            DriverTableSeeder::class,
            TripTypeSeeder::class,
        ]);
    }
}

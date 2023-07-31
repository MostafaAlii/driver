<?php

namespace Database\Seeders;

use App\Models\ServiceLocations;
use App\Models\VehicleTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class VehicleTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('vehicle_types')->truncate();
        for ($i = 0, $ii = 20; $i < $ii; $i++) {
            VehicleTypes::create([
                'service_location_id' => ServiceLocations::all()->random()->id,
                'name' => fake()->name(),
                'icon' => fake()->name(),
                'capacity' => fake()->name(),
                'is_accept_share_ride' => fake()->randomElement([true, false]),
                'status' => fake()->randomElement([true, false]),
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}

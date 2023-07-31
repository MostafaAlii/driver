<?php

namespace Database\Seeders;

use App\Models\VehicleTypes;
use App\Models\Zone;
use App\Models\ZoneTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ZoneTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('zone_types')->truncate();
        for ($i = 0, $ii = 25; $i < $ii; $i++) {
            ZoneTypes::create([
                'zone_id' => fake()->randomElement(Zone::whereStatus(true)->pluck('id')),
                'vehicle_type_id' => fake()->randomElement(VehicleTypes::whereStatus(true)->pluck('id')),
                'bill_status' => fake()->name(),
                'payment_type' => fake()->name(),
                'status' => fake()->randomElement([true, false]),
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}

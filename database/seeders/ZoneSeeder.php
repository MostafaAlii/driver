<?php

namespace Database\Seeders;

use App\Models\ServiceLocations;
use App\Models\Zone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('zones')->truncate();

        for ($i = 0, $ii = 25; $i < $ii; $i++) {



            Zone::create([
                'service_location_id' => ServiceLocations::all()->random()->id,
                'name' => fake()->name(),
                'unit'=> fake()->name(),
                'coordinates' =>  null, // Randomly choose 1 to 3 polygons
                'status' => fake()->randomElement([true,false]),
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}

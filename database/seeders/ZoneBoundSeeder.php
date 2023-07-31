<?php

namespace Database\Seeders;

use App\Models\Zone;
use App\Models\ZoneBound;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ZoneBoundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('zone_bounds')->truncate();
        for ($i = 0, $ii = 25; $i < $ii; $i++) {
            ZoneBound::create([
                'zone_id' => fake()->randomElement(Zone::whereStatus(true)->pluck('id')),
                'north' => fake()->name(),
                'east' => fake()->name(),
                'south' => fake()->name(),
                'west' => fake()->name(),
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}

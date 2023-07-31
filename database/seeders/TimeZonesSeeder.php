<?php

namespace Database\Seeders;

use App\Models\TimeZones;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TimeZonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('time_zones')->truncate();

        for ($i = 0, $ii = 20; $i < $ii; $i++) {
            TimeZones::create([
                'name' => fake()->name(),
                'timezone' => fake()->timezone(),
                'active' => fake()->randomElement([true, false]),
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\ServiceLocations;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ServiceLocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('service_locations')->truncate();

        for ($i = 0, $ii = 20; $i < $ii; $i++) {
            ServiceLocations::create([
                'name' => fake()->name(),
                'currency_name' => fake()->century(),
                'currency_code' => fake()->currencyCode(),
                'timezone' => fake()->timezone(),
                'country_id' => Country::whereStatus(true)->pluck('id')->random(),
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}

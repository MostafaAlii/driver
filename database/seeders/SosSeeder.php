<?php

namespace Database\Seeders;

use App\Models\Sos;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\{DB, Schema};

class SosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('sos')->truncate();
        Sos::factory()->count(50)->create();
        Schema::enableForeignKeyConstraints();
    }
}

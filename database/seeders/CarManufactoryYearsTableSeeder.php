<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\CarManufactoryYear;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
class CarManufactoryYearsTableSeeder extends Seeder {
    public function run(): void {
        Schema::disableForeignKeyConstraints();
        CarManufactoryYear::truncate();
        CarManufactoryYear::factory()->count(50)->create();
        Schema::enableForeignKeyConstraints();
    }
}

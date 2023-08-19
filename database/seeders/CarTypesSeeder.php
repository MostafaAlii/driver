<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CarType;
use Illuminate\Support\Facades\{DB, Schema};
class CarTypesSeeder extends Seeder {
    public function run(): void {
        Schema::disableForeignKeyConstraints();
        DB::table('car_types')->truncate();
        $types = ['A', 'A+', 'A Class', 'B', 'B+', 'B Class'];
        foreach ($types as $type) {
            CarType::create(['name' => $type, 'status' => true]);
        }
        Schema::enableForeignKeyConstraints();
    }
}

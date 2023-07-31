<?php

namespace Database\Seeders;
use App\Models\Driver;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Schema};
use Illuminate\Support\Str;

class DriverTableSeeder extends Seeder
{
    public function run() {
        Schema::disableForeignKeyConstraints();
        DB::table('drivers')->delete();
        $driver = Driver::create([
            'name'          =>  'Mostafa Alii Driver',
            'email'         =>  'driver@app.com',
            'password'      =>  bcrypt('123123'),
            'status'        =>  'active',
            'phone'         =>  '123456789',
            'gender'        => 'male',
            'country_id'    =>  65,
            'remember_token' => Str::random(10),
        ]);
        $driver = Driver::create([
            'name'          =>  'Mostafa Driver',
            'email'         =>  'dr@app.com',
            'password'      =>  bcrypt('123123'),
            'status'        =>  'active',
            'gender'        => 'male',
            'country_id'    =>  65,
            'remember_token' => Str::random(10),
        ]);
        Driver::factory()->count(10)->create();
        Schema::enableForeignKeyConstraints();
    }
}

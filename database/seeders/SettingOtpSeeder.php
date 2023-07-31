<?php

namespace Database\Seeders;

use App\Models\SettingOtp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingOtpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('setting_otps')->truncate();
        for ($i = 0, $ii = 25; $i < $ii; $i++) {
            SettingOtp::create([
                'Usertype_type' => fake()->randomElement(['user', 'driver']),
                'Usertype_id' => fake()->randomElement([32, 45]),
                'phone' => fake()->phoneNumber(),
                'verified' => fake()->randomElement([true, false]),
                'otp' => fake()->postcode(),
            ]);
        }
    }
}

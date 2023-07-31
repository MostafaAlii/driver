<?php

namespace Database\Factories;

use App\Models\{ServiceLocations,Admin};
use Illuminate\Database\Eloquent\Factories\Factory;

class SosFactory extends Factory {
    public function definition(): array {
        return [
            'service_location_id' => ServiceLocations::all()->random()->id,
            'admin_id' => function () {
                return Admin::factory()->create()->id;
            },
            'name' => $this->faker->name,
            'number' => $this->faker->phoneNumber,
            'status' => $this->faker->randomElement(['active', 'inactive'])
        ];
    }
}

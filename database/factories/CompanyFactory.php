<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Admin, Company, Country};
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;
    public function definition(): array {
        return [
            'name' => $this->faker->company,
            'mobile' => $this->faker->phoneNumber,
            'landline' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'address' => $this->faker->address,
            'postal_code' => $this->faker->postcode,
            'state' => $this->faker->state,
            'status' => $this->faker->boolean,
            'admin_id' => fn() => Admin::factory()->create()->id,
            'country_id' => Country::all()->random()->id,
        ];
    }
}

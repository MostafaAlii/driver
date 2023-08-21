<?php
namespace Database\Factories;
use App\Models\{CarManufactoryYear, CarType};
use Illuminate\Database\Eloquent\Factories\Factory;

class CarManufactoryYearFactory extends Factory {
    protected $model = CarManufactoryYear::class;
    public function definition(): array {
        $carType = CarType::inRandomOrder()->first();
        $startYear = 2003;
        $endYear = date('Y');
        return [
            'year' => $this->faker->numberBetween($startYear, $endYear),
            'car_type_id' => $carType->id,
        ];
    }
}

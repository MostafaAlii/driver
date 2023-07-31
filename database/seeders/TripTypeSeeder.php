<?php
namespace Database\Seeders;
use App\Models\TripType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\{DB,Schema};
class TripTypeSeeder extends Seeder {
    public function run(): void {
        Schema::disableForeignKeyConstraints();
        DB::table('trip_types')->truncate();
        $tripTypes = [
            [
                'name' => 'مشوار واحد',
                'description' => 'مشوار واحد',
                'properties' => [
                    'meeting_point' => '1.55555',
                    'access_point' => '155.55555',
                ],
            ],
            [
                'name' => 'مشوار متعدد',
                'description' => 'مشوار متعدد يحسب بالساعات داخل المدينة',
                'properties' => [
                    'time' => '8',
                    'state_id' => DB::table('countries')
                                    ->join('states', 'countries.id', '=', 'states.country_id')
                                    ->where('countries.name', 'Egypt')
                                    ->where('states.status', 1)
                                    ->inRandomOrder()
                                    ->pluck('states.id')
                                    ->first()

                ],
            ],
            [
                'name' => 'مشوار سياحى',
                'description' => 'مشوار سياحى يحسب بالايام',
                'properties' => [
                    'days' => '3',
                ],
            ],
        ];
        foreach ($tripTypes as $tripTypeData) {
            $properties = $tripTypeData['properties'];
            unset($tripTypeData['properties']);
            $tripType = TripType::create($tripTypeData);

            if (!empty($properties)) {
                foreach ($properties as $propertyKey => $propertyValue) {
                    $tripType->properties()->create([
                        'key' => $propertyKey,
                        'value' => $propertyValue,
                    ]);
                }
            }
        }
        Schema::enableForeignKeyConstraints();
    }
}

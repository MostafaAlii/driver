<?php
namespace App\Http\Resources\Drivers;
use Illuminate\Http\Request;
use App\Http\Resources\{CarMakeResources,CarModelResources,VehicleTypeResources};
use Illuminate\Http\Resources\Json\JsonResource;
class DriverProfileResources extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'address' => $this->address,
            'bio' => $this->bio,
            'vehicle_type_id' => new VehicleTypeResources($this->vehicle_type),
            'car_make_id' => new CarMakeResources($this->car_make),
            'car_model_id' => new CarModelResources($this->car_model),
            'car_number' => $this->car_number,
            'car_color' => $this->car_color,
            'nationality_id' => $this->nationality_id,
            'today_trip_count' => $this->today_trip_count,
            'total_accept' => $this->total_accept,
            'total_reject'  => $this->total_reject,
            'acceptance_ratio' => $this->acceptance_ratio,
            'last_trip_date' => $this->last_trip_date,
            'status' => $this->status,
            'avatar' => $this->getAvatarUrl(),
        ];
    }

    private function getAvatarUrl(): ?string {
            if (!empty($this->avatar)) 
                return asset('dashboard/images/driver_document/' . $this->owner->email . $this->owner->phone . '_' . $this->uuid . '/' . $this->avatar);
            return asset('dashboard/default/default_admin.jpg');
    }
}


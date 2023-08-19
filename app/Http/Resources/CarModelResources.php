<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarModelResources extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'carMake' => new CarMakeResources($this->car_make),
            'carType' => new CarTypeResource($this->carType),
            'status' => $this->status(),
        ];
    }
}

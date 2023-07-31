<?php

namespace App\Http\Resources;

use App\Http\Resources\Drivers\DriverResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverActivityResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'driver' => new DriverResources($this->driver),
            'lan' => $this->lan,
            'lat' => $this->lat,
            'type' => $this->type,
        ];
    }
}

<?php

namespace App\Http\Resources\Drivers;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResources extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => new DriverProfileResources($this->profile),
            //'images' => $this->getFirstMediaUrl(Driver::COLLECTION_NAME) ?? asset('dashboard/default/default_admin.jpg'),
        ];
    }
}

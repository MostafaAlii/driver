<?php

namespace App\Http\Resources\Users;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use newrelic\DistributedTracePayload;

class UserResources extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => new UserProfileResources($this->profile),
            'images' => $this->getFirstMediaUrl(User::COLLECTION_NAME) ?? asset('dashboard/default/default_admin.jpg'),
        ];
    }
}

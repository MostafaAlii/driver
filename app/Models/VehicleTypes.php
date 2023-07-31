<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleTypes extends Model
{
    use HasFactory, Historyable;

    protected $fillable = [
        'service_location_id',
        'name',
        'icon',
        'capacity',
        'is_accept_share_ride',
        'status',
    ];

    public function service_location()
    {
        return $this->belongsTo(ServiceLocations::class, 'service_location_id');
    }

    public function is_accept_share_ride()
    {
        return $this->is_accept_share_ride ? 'Yes' : 'No';
    }

    public function status()
    {
        return $this->status ? 'Active' : 'No Active';
    }
}

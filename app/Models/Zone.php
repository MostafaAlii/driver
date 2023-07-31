<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Zone extends Model
{
    use HasFactory, Historyable;

    protected $fillable = [
        'service_location_id',
        'name',
        'unit',
        'coordinates',
        'status',
    ];

    public function service_location()
    {
        return $this->belongsTo(ServiceLocations::class,'service_location_id');
    }

    public function status()
    {
        return $this->status ? 'Active' : 'NO Active';
    }

    public function driverDetails() {
        return $this->hasOne(DriverDetails::class, 'zone_id');
    }
}

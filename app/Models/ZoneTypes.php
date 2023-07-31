<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ZoneTypes extends Model
{
    use HasFactory, Historyable;

    protected $fillable = [
        'zone_id',
        'vehicle_type_id',
        'bill_status',
        'payment_type',
        'status',
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function vehicle_type()
    {
        return $this->belongsTo(VehicleTypes::class, 'vehicle_type_id');
    }

    public function status()
    {
        return $this->status ? 'Active' : 'No Active';
    }
}

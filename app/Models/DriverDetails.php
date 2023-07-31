<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DriverDetails extends Model
{
    use HasFactory, Historyable;
    protected $table = 'driver_details';
    public $timestamps = false;
    protected $fillable = [
        'driver_id',
        'zone_id',
        'company_id',
        'longitude',
        'latitude',
        'is_company_driver',
    ];
    protected $casts = [
        'longitude' => 'double',
        'latitude' => 'double',
        'is_company_driver' => 'boolean',
    ];
    public function driver() {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function zone() {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function company() {
        return $this->belongsTo(Company::class, 'company_id');
    }
}

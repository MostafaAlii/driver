<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'lan',
        'lat',
        'type',
        'status',
        'trip
        ',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class,'driver_id');
    }
}

<?php
declare (strict_types = 1);
namespace App\Observers;
use App\Models\Driver;
use App\Models\DriverDetails;

class DriverObserver {
    public function created(Driver $driver): void {
        $driver->profile()->create([]);
        $driver->driverDetails()->create([]);
         
    }
}
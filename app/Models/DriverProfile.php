<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DriverProfile extends BaseModel {
    protected $table = 'driver_profiles';
    protected $fillable = ['status', 'name', 'bio', 'driver_id', 
    'uuid', 'nationality_id', 'vehicle_type_id', 'car_model_id', 
    'car_make_id', 'car_number', 'car_color', 'avatar',
    'today_trip_count', 'total_accept', 'acceptance_ratio', 'last_trip_date'];

    public function owner(): BelongsTo {
        return $this->belongsTo(related: Driver::class, foreignKey: 'driver_id');
    }

    public function vehicle_type(): BelongsTo {
        return $this->belongsTo(related: VehicleTypes::class, foreignKey: 'vehicle_type_id');
    }

    public function car_make(): BelongsTo {
        return $this->belongsTo(related: CarMake::class, foreignKey: 'car_make_id');
    }

    public function car_model(): BelongsTo {
        return $this->belongsTo(related: CarModel::class, foreignKey: 'car_model_id');
    }

    public function profileMedia(): HasMany {
        return $this->hasMany(related: DriverProfileMedia::class, foreignKey: 'driver_profile_id');
    }
}

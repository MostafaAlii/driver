<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class DriverProfileMedia extends Model {
    protected $table = 'driver_profiles_media';
    protected $fillable = [
        'license_front',
        'license_back',
        'car_license_front',
        'car_license_back',
        'personal_identification_front',
        'personal_identification_back',
        'criminal_record',
        'car_front_side',
        'car_back_side',
        'car_right_side',
        'car_left_side',
        'car_inside',
        'car_plate',
        'driver_profile_id'
    ];
    public function driverProfile() {
        return $this->belongsTo(DriverProfile::class, 'driver_profile_id');
    }

    public function mediaFilesStatus() {
        return $this->hasOne(MediaFilesStatus::class);
    }
}
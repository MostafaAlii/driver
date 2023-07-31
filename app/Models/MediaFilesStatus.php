<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MediaFilesStatus extends Model {
    protected $table = 'media_files_status';
    protected $fillable = [
        'driver_profiles_media_id',
        'type',
        'status'
    ];
    public function driverProfileMedia() {
        return $this->belongsTo(DriverProfileMedia::class, 'driver_profiles_media_id');
    }
}
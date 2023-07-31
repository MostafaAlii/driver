<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sos extends Model
{
    use HasFactory, Historyable;
    protected $fillable = [
        'service_location_id',
        'admin_id',
        'name',
        'number',
        'status'
    ];

    public function serviceLocation() {
        return $this->belongsTo(ServiceLocations::class, 'service_location_id');
    }

    public function admin() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}

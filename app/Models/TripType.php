<?php
namespace App\Models;
use App\Models\Concerns\History\Historyable;
class TripType extends BaseModel {
    use Historyable;
    protected $table = 'trip_types';
    protected $fillable = ['name', 'description', 'uuid', 'status'];
    protected $casts = ['status' => 'boolean',];

    public function properties() {
        return $this->hasMany(TripTypeProperties::class, 'trip_type_id');
    }

    public function trips() {
        return $this->hasMany(Trip::class, 'trip_type_id');
    }
}

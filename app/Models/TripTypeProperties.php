<?php
namespace App\Models;
use App\Models\Concerns\History\Historyable;
class TripTypeProperties extends BaseModel {
    use Historyable;
    protected $table = 'trip_type_properties';
    protected $fillable = ['key', 'state_id', 'value', 'trip_type_id', 'uuid', 'status'];
    protected $casts = ['status' => 'boolean',];
    public function tripType() {
        return $this->belongsTo(TripType::class, 'trip_type_id');
    }
    public function state() {
        return $this->belongsTo(State::class, 'state_id');
    }
}
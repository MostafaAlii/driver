<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarManufactoryYear extends Model {
    use HasFactory, Historyable;
    protected $table = 'car_manufactory_years';
    protected $fillable = [
        'year',
        'car_type_id',
    ];

    public function carType(): BelongsTo {
        return $this->belongsTo(CarType::class);
    }
}

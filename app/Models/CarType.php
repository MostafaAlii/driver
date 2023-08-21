<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarType extends Model {
    use HasFactory, Historyable;
    protected $fillable = ['name', 'status'];

    
    public function carManufactoryYears() {
        return $this->hasMany(CarManufactoryYear::class)->orderBy('year', 'desc');
    }

    public function status() {
        return $this->status ? 'Active' : 'No Active';
    }

    public function scopeActive() {
        return $this->whereStatus(true)->get();
    }

}

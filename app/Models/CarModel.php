<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarModel extends Model
{
    use HasFactory, Historyable;

    protected $fillable = [
        'name',
        'status',
        'car_make_id',
    ];

    public function car_make()
    {
        return $this->belongsTo(CarMake::class, 'car_make_id');
    }

    public function status()
    {
        return $this->status ? 'Active' : 'No Active';
    }
}
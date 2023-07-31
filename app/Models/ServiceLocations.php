<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceLocations extends Model
{
    use HasFactory, Historyable;

    protected $fillable = [
        'name',
        'currency_name',
        'currency_code',
        'timezone',
        'country_id',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

}

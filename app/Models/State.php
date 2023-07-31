<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory, Historyable;

    protected $fillable = [
        'name',
        'country_id',
        'status',
    ];

    public function cities()
    {
        return $this->hasMany(City::class, 'state_id');
    }

    public function status()
    {
        return $this->status  ? 'Active' : 'NO Active';
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory, Historyable;

    protected $fillable = [
        'name',
        'state_id',
        'status',
    ];


    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function status()
    {
        return $this->status != false ? 'Active' : 'NO Active';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ZoneBound extends Model
{
    use HasFactory, Historyable;

    protected $fillable = [
        'zone_id',
        'north',
        'east',
        'south',
        'west',
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }
}

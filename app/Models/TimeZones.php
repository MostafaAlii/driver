<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeZones extends Model
{
    use HasFactory, Historyable;

    protected $fillable = [
        'name',
        'timezone',
        'active',
    ];

    public function status()
    {
        return $this->active ? 'Active' : 'No Active';
    }
}

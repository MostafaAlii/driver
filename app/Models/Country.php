<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory, Historyable;
    protected $fillable = ['name', 'status'];

    public function states()
    {
        return $this->hasMany(State::class, 'country_id');
    }

    public function status()
    {
        return $this->status ? 'Active' : 'NO Active';
    }

    public static function active() {
        return self::whereStatus(true)->get();
    }
}

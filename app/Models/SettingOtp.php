<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SettingOtp extends Model
{
    use HasFactory, Historyable;

    protected $fillable = [
        'Usertype_type',
        'Usertype_id',
        'phone',
        'verified',
        'otp',
    ];

    public function status()
    {
        return $this->verified ? 'Success' : 'Filed';
    }
}

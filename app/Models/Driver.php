<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Models\Concerns\History\Historyable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\{HasOne, BelongsTo};
class Driver extends Authenticatable implements JWTSubject {
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Historyable;
    const COLLECTION_NAME = 'drivers_avatar'; 
    const DRIVER_OTP = '123';
    protected $table = 'drivers';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'status',
        'email_verified_at',
        'gender',
        'lat',
        'lan',
        'country_id',
        'car_type_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function profile(): HasOne {
        return $this->hasOne(related:DriverProfile::class, foreignKey:'driver_id');
    }

    public function driverDetails(): HasOne  {
        return $this->hasOne(related:DriverDetails::class, foreignKey:'driver_id');
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    public function country(): BelongsTo {
        return $this->belongsTo(related:Country::class, foreignKey:'country_id');
    }

    public function car_type(): BelongsTo {
        return $this->belongsTo(related:CarType::class, foreignKey:'car_type_id');
    }
}
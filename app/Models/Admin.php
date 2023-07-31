<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Concerns\History\Historyable;
use App\Enum\{AdminStatus, AdminTypes};
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable implements JWTSubject {
    use HasApiTokens, HasFactory, Notifiable, Historyable;

    const COLLECTION_NAME = 'admins_avatar';
    protected $table = 'admins';
    protected $fillable = ['name', 'country_id', 'email', 'password', 'phone', 'link_password_protection', 'status', 'type', 'link_password_status'];
    protected $hidden = ['password', 'remember_token',];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'link_password_status' => 'boolean',

    ];

    

    public function profile(): HasOne {
        return $this->hasOne(related: AdminProfile::class, foreignKey: 'admin_id');
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    public function country() {
        return $this->belongsTo(Country::class, 'country_id');
    }


    public function checkCountry() {
        if (auth('admin')->user()->type == "general"){
            return true;
        }else{
            return true;
        }
    }
}
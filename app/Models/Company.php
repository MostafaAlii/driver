<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\{HasMedia, InteractsWithMedia, MediaCollections\File};

class Company extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia, Historyable, Historyable;
    const COLLECTION_NAME = 'companies_avatar';
    protected $fillable = [
        'name',
        'mobile',
        'landline',
        'email',
        'address',
        'postal_code',
        'state',
        'status',
        'admin_id',
        'country_id',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function country() {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function status() {
        return $this->status ? 'Active' : 'No Active';
    }

    public function registerMediaCollections(): void {
        $this->addMediaCollection(Company::COLLECTION_NAME)
            ->singleFile()
            ->useFallbackUrl(asset('dashboard/default/default_company.png'))
            ->acceptsFile(function (File $file) {
                return $file->mimeType === 'image/jpeg' || $file->mimeType === 'image/png';
            });
    }

    public function profile(): HasOne {
        return $this->hasOne(related:CompanyProfile::class, foreignKey:'company_id');
    }

    public function driverDetails(): HasOne {
        return $this->hasOne(related:DriverDetails::class, foreignKey:'company_id');
    }
}

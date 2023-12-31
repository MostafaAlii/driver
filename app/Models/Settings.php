<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use phpDocumentor\Reflection\Types\Self_;
use App\Models\Concerns\History\Historyable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\{HasMedia, InteractsWithMedia, MediaCollections\File};

class Settings extends Model implements HasMedia { 
    use HasFactory, InteractsWithMedia, SoftDeletes, Historyable, Translatable;
    const COLLECTION_NAME = 'setting_app_icon';
    protected $table = "settings";
    protected $fillable = [
        'facebook',
        'instagram',
        'phone',
        'whatsapp',
        'email',
        'version',
        'open_door',
        'waiting_price',
        'country_tax',
        'kilo_price',
        'api_secret_key',
        'ocean',
        'company_commission',
        'company_tax',
        'image'
    ];

    protected $with = ['translations'];
    public $translatedAttributes = ['name', 'author', 'address', 'description', 'road_toll'];

    public function peekTimeFees(): HasMany{
        return $this->hasMany(SettingPeekTimeFee::class, 'settings_id');
    }

    public function registerMediaCollections(): void {
        $this->addMediaCollection(Settings::COLLECTION_NAME)
            ->singleFile()
            ->useFallbackUrl(asset('dashboard/default/default_logo.jpg'))
            ->acceptsFile(function (File $file) {
                return $file->mimeType === 'image/jpeg' || $file->mimeType === 'image/png';
            });
    }

    public static function checkSettings() {
        $settings = Self::all();
        if (count($settings) < 1) {
            $data = ['id' => 1];
            foreach (config('app.languages') as $key => $value) {
                $data[$key]['name'] = 'name-' . $value;
                $data[$key]['author'] = 'author-' . $value;
                $data[$key]['address'] = 'address-' . $value;
                $data[$key]['description'] = 'description-' . $value;
                $data[$key]['road_toll'] = 'road_toll-' . $value;
            }
            self::create($data);
        }
        return Self::first();
    }
}

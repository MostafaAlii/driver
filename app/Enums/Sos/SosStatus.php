<?php
namespace App\Enums\Sos;
enum SosStatus: string {
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function status() {
        return match($this) {
            self::ACTIVE => 'active',
            self::INACTIVE => 'inactive',
        };
    }
}
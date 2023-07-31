<?php
namespace App\Enums\Admin;
enum AdminStatus: string {
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function status() {
        return match($this) {
            self::ACTIVE => 'active',
            self::INACTIVE => 'inactive',
        };
    }
}
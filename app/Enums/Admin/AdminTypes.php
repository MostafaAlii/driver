<?php
namespace App\Enums\Admin;
enum  AdminTypes: string {
    case ADMIN = 'admin';
    case SUPERVISOR = 'supervisor';
    case GENERAL = 'general';

    public function type() {
        return match($this) {
            self::ADMIN => 'admin',
            self::SUPERVISOR => 'supervisor',
            self::GENERAL => 'general',
        };
    }
}

<?php
declare (strict_types = 1);
namespace App\Observers;
use App\Models\Admin;
class AdminObserver {
    public function created(Admin $admin): void {
        $admin->profile()->create([]);
    }

    public function deleting(Admin $admin): void {
        $medias = $admin->getMedia();
        foreach ($medias as $media) {
            $media->delete();
        }
    }
    
}
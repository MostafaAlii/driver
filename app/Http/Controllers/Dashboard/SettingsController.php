<?php
namespace App\Http\Controllers\Dashboard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\MainSettingRepositoryInterface;

class SettingsController extends Controller {
    public function __construct(protected MainSettingRepositoryInterface $settingRepository) {
        $this->settingRepository = $settingRepository;
    }
    public function index() {
        return $this->settingRepository->index();
    }

    public function update(Request $request) {
        return $this->settingRepository->update($request);
    }
}

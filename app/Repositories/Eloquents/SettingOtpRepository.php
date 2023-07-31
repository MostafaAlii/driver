<?php
namespace  App\Repositories\Eloquents;
use App\DataTables\SettingOtpDataTable;
use App\Models\SettingOtp;
use App\Repositories\Contracts\SettingOtpRepositoryInterface;
use Illuminate\Http\Request;
class SettingOtpRepository implements SettingOtpRepositoryInterface {
    public function index(SettingOtpDataTable $settingOtpDataTable)
    {
        return $settingOtpDataTable->render('dashboard.settingOtp.index', ['title' => 'settingOtp']);
    }

}

<?php
namespace  App\Repositories\Contracts;
use App\DataTables\SettingOtpDataTable;
use Illuminate\Http\Request;

interface SettingOtpRepositoryInterface {
    public function index(SettingOtpDataTable $settingOtpDataTable);

}

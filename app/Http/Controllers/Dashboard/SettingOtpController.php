<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\SettingOtpDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\SettingOtpRepositoryInterface;
use Illuminate\Http\Request;

class SettingOtpController extends Controller
{
    public function __construct(protected SettingOtpDataTable $settingOtpDataTable, protected SettingOtpRepositoryInterface $settingOtpInterface)
    {
        $this->settingOtpDataTable = $settingOtpDataTable;
        $this->settingOtpInterface = $settingOtpInterface;
    }

    public function index(SettingOtpDataTable $settingOtpDataTable)
    {
        return $this->settingOtpInterface->index($settingOtpDataTable);
    }
}

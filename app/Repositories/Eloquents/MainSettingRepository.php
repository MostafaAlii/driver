<?php

namespace  App\Repositories\Eloquents;

use App\Models\{Settings, SettingPeekTimeFee};
use App\Repositories\Contracts\MainSettingRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainSettingRepository implements MainSettingRepositoryInterface
{
    public function index() {
        return view('dashboard.settings.index', ['title' => 'Main Settings']);
    }

    public function update($request) {
        $settingData = $request->except(['_token', 'image']);
        $setting = Settings::updateOrCreate(['id' => 1], $settingData);
        DB::table('setting_peek_time_fees')->delete();
        $data = $request->peek_time_fees;
        foreach ($data as $peekTimeFeeData) {
            SettingPeekTimeFee::create([
                'settings_id' => 1,
                'start_date' => $peekTimeFeeData['start_date'],
                'end_date' => $peekTimeFeeData['end_date'],
                'price' => $peekTimeFeeData['price'],
            ]);
        }
        if ($request->hasFile('image')) {
            $setting->addMediaFromRequest('image')->toMediaCollection(Settings::COLLECTION_NAME);
        }
        $notification = [
            'message' => 'Settings updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    }
}
